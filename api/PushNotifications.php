<?php 
// Server file
class PushNotifications {

	// (Android)API access key from Google API's Console.
//	private static $API_ACCESS_KEY = 'AIzaSyBw9DqGma4BOpfzPEShPdd4fqm-HR76WNU';
	private static $API_ACCESS_KEY = 'AIzaSyCcdljdTigvx-R5OH5C3S9AP3Kl4J7FNBo';
//	private static $API_ACCESS_KEY = 'AIzaSyDG3fYAj1uW7VB-wejaMJyJXiO5JagAsYI';
	// (iOS) Private key's passphrase.
	private static $passphrase = 'joashp';
	// (Windows Phone 8) The name of our push channel.
        private static $channelName = "joashp";
	
	// Change the above three vriables as per your app.

	public function __construct() {
		exit('Init function is not allowed');
	}
	
        // Sends Push notification for Android users
	public function android($data, $reg_id) {
	        $url = 'https://android.googleapis.com/gcm/send';
	        $message = array(
	            'title' => $data['mtitle'],
	            'latitude' => $data['mdesc1'],
	            'longitude' => $data['mdesc2'],
	            'subtitle' => '',
	            'tickerText' => '',
	            'msgcnt' => 1,
	            'vibrate' => 1
	        );
	        define('GOOGLE_API_KEY', 'AIzaSyCcdljdTigvx-R5OH5C3S9AP3Kl4J7FNBo');

		$headers = array(
		    'Authorization:key=' . GOOGLE_API_KEY,
		    'Content-Type: application/json'
		);
	   //     $headers = array(
	   //     	'Authorization: key=' .self::$API_ACCESS_KEY,
	   //     	'Content-Type: application/json'
	   //     );
	
	        $fields = array(
	            'registration_ids' => array($reg_id),
	            'data' => $message,
	        );
	    //	return $this->useCurl($url, $headers, json_encode($fields));
	    $fields1 = json_encode($fields);
	    	
	    	$ch = curl_init();
	        if ($url) {
	            // Set the url, number of POST vars, POST data
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     
	            // Disabling SSL Certificate support temporarly
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            if ($fields) {
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields1);
	            }
	     
	            // Execute post
	            $result = curl_exec($ch);
	            if ($result === FALSE) {
	                die('Curl failed: ' . curl_error($ch));
	            }
	     
	            // Close connection
	            curl_close($ch);
	
	            return $result;
	            }
    	}
	
	// Sends Push's toast notification for Windows Phone 8 users
	public function WP($data, $uri) {
		$delay = 2;
		$msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
		        "<wp:Notification xmlns:wp=\"WPNotification\">" .
		            "<wp:Toast>" .
		                "<wp:Text1>".htmlspecialchars($data['mtitle'])."</wp:Text1>" .
		                "<wp:Text2>".htmlspecialchars($data['mdesc'])."</wp:Text2>" .
		            "</wp:Toast>" .
		        "</wp:Notification>";
		
		$sendedheaders =  array(
		    'Content-Type: text/xml',
		    'Accept: application/*',
		    'X-WindowsPhone-Target: toast',
		    "X-NotificationClass: $delay"
		);
		
		$response = $this->useCurl($uri, $sendedheaders, $msg);
		
		$result = array();
		foreach(explode("\n", $response) as $line) {
		    $tab = explode(":", $line, 2);
		    if (count($tab) == 2)
		        $result[$tab[0]] = trim($tab[1]);
		}
		
		return $result;
	}
	
        // Sends Push notification for iOS users
	public function iOS($data, $devicetoken) {

		$deviceToken = $devicetoken;

		$ctx = stream_context_create();
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => $data['mtitle'],
                'body' => $data['mdesc'],
			 ),
			'sound' => 'default'
		);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);

		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message successfully delivered' . PHP_EOL;

	}
	
	// Curl 
	private function useCurl($url, $headers, $fields) {

	        // Open connection
	        $ch = curl_init();
	        if ($url) {
	            // Set the url, number of POST vars, POST data
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     
	            // Disabling SSL Certificate support temporarly
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            if ($fields) {
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	            }
	     
	            // Execute post
	            $result = curl_exec($ch);
	            if ($result === FALSE) {
	                die('Curl failed: ' . curl_error($ch));
	            }
	     
	            // Close connection
	            curl_close($ch);
	            return $result;
        }
    }
    
}

function send_notification($title,$latitude, $longitude , $deviceToken) {
	// Message payload
	$msg_payload = array (
		'mtitle' => "$title",
		'mdesc1' => "$latitude",
		'mdesc2' => "$longitude",
	);
	
	// For Android
	$regId = 'dENO33vB2es:APA91bH5iBepF4fXEeukkafTXhV6oS95FyZbk_tkJGWiWRHbsShzRcpIVRKK33bdBDkeCC4aGKZa4BcIvuUh2_yugkpEly0PY_39YDWXqIMxr4Jhrhgyl-b5NU0ksyPcikToP2LDSlb6';

	//$regId = 'APA91bHdOmMHiRo5jJRM1jvxmGqhComcpVFDqBcPfLVvaieHeFI9WVrwoDeVVD1nPZ82rV2DxcyVv-oMMl5CJPhVXnLrzKiacR99eQ_irrYogy7typHQDb5sg4NB8zn6rFpiBuikNuwDQzr-2abV6Gl_VWDZlJOf4w';
	// For iOS
	//$deviceToken = 'FE66489F304DC75B8D6E8200DFF8A456E8DAEACEC428B427E9518741C92C6660';
	// For WP8
	$uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';
	
	// Replace the above variable values
	
	
    	PushNotifications::android($msg_payload, $regId);
    	
 //   	PushNotifications::WP8($msg_payload, $uri);
    	
  //  	PushNotifications::iOS($msg_payload, $deviceToken);
}
?>