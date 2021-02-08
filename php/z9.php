<?php
//set_time_limit(0); 
$ngoname = 0;
$ngoemail = 0;
$phonengo = 0 ;
$url = 'https://api.sendgrid.com/';
//$user = 'azure_09cd2f21a37b9dc30337ba4eafdc5e7c@azure.com';
$user = '_';
$pass = '_';
$to="tharwani@iitk.ac.in";
$message="succesfully initiated donation request to ".$ngoname.".You can contact them at E-mail ID:".$ngoemail." or phone number:".$phonengo;
$params = array(
     'api_user' => $user,
     'api_key' => $pass,
     'to' => $to,
     'subject' => 'Delayed MAIL_new',
     'html' => $message,
     'text' => $message,
     'from' => 'team@bliss19.azurewebsites.net'
  );
//   ob_start();
//   sleep(1800);
//   ob_end_flush();
$request = $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);

// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);

// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
//curl_close($session);

// print everything out
print_r($response);
?>