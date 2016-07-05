#! /usr/bin/python

import getopt
import csv
import sys
import os
from sys import argv
from os.path import exists
from os import makedirs
from os import symlink
from os import system
from io import BytesIO

try:
    from urllib.request  import urlopen
except ImportError:
    from urllib2 import urlopen
from zipfile import ZipFile


#
#   Show Usage, Output to STDERR
#
def show_usage():
	print """
	Create a new vHost in Ubuntu Server
	Assumes /etc/apache2/sites-available and /etc/apache2/sites-enabled setup used

	    -h    Help - Show this menu.
	    -f    FileName - i.e. Sample.csv
	"""
	exit(1)

#
#   Output vHost skeleton, fill with userinput
#   To be outputted into new file
#webmaster@localhost
def create_vhost(admin, documentroot, servername):
	out = """<VirtualHost *:80>
    ServerAdmin %s
    ServerName %s

    DocumentRoot %s

    <Directory %s>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/%s-error.log

    # Possible values include: debug, info, notice, warn, error, crit,
    # alert, emerg.
    LogLevel warn

    CustomLog ${APACHE_LOG_DIR}/%s-access.log combined

</VirtualHost>""" % (admin, servername, documentroot, documentroot, servername, servername)
	return out

###### process
def do_vhost(documentroot, servername, admin):
    if exists(documentRoot) == False:
        makedirs(documentRoot, 0755)
        #chown USER:USER $DocumentRoot #POSSIBLE IMPLEMENTATION, new flag -u ?
        #from pwd import getpwnam  -> inspect: getpwnam('someuser')

    if exists('%s/%s.conf' % (documentRoot, serverName)):
        print 'vHost already exists. Aborting'
       	#show_usage()
        return

    else:
        target = open('/etc/apache2/sites-available/%s.conf' % serverName, 'w')
        target.write(create_vhost(admin, documentRoot, serverName))
        target.close()

        srcLink = '/etc/apache2/sites-available/%s.conf' % serverName
        destLink = '/etc/apache2/sites-enabled/%s.conf' % serverName
        try:
            symlink(srcLink, destLink)
        except OSError, err:
            #print str(err)
            pass

### download zip and extract as the same name of site
def get_template(site, template):
    with urlopen(template) as zipresp:
        with ZipFile(BytesIO(zipresp.read())) as zfile:
            print site, template
            zfile.extractall('/var/www/' + site)

##################################################
## starting the process
#Parse flags, fancy python way. Long options also!
try:		
    opts, args = getopt.getopt(argv[1:], "hf:", ["help", 'file-name='])
except getopt.GetoptError, err:
    print str(err)
    show_usage()

#Sanity check - make sure there are arguments
if opts.__len__() == 0:
	show_usage()

documentRoot = None
serverName = None

#Get values from flags
for option, value in opts:
	if option in ('-h', '--help'):
		show_usage()
	elif option in ('-f', '--file-name'):
		csvName = value
	else:
		print "Unknown parameter used"
		show_usage()
#### loop csv content
#sys.argv[1]
f = open(csvName, 'rt')
try:
    reader = csv.reader(f)
    is_header = True
    for row in reader:
        if is_header:
            is_header = False
            continue

        site = row[0]
        webAccUser = row[1]
        webAccPwd = row[2]
        devAccRootLoc = row[3]
        devUser = row[4]
        devPwd = row[5]
        template = row[6]
        ### making conf
        documentRoot = '/var/www/' + site
        do_vhost(webAccUser, documentRoot, site)
        ### processing site source
        #get_template(site, template)

finally:
    f.close()

system('service apache2 reload')

