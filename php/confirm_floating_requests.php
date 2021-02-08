<?php
$name=$_GET['name'];
$mail=$_GET['mail'];
$phone=$_GET['phone'];
$origin=$_GET['origin'];
$destination=$_GET['destination'];
$namengo=$_GET['namengo'];
$mailngo=$_GET['mailngo'];
$phonengo=$_GET['phonengo'];
$date=$_GET['date'];
$time=$_GET['time'];
$distance_taken=$_GET['distance_taken'];
$time_taken=$_GET['time_taken'];

$url = 'https://api.sendgrid.com/';
$user ='_';
$pass = '_';
$message="<p align=center>*****donation confirmed****</p>You have successfully donated to ".$namengo.".You can contact them at <br>E-mail ID:".$mailngo."<br>Phone number:".$phonengo."<br>Address:".$origin."<br><br>regards<br>team Bliss";
$to=$mail;
$params = array(
    'api_user' => $user,
    'api_key' => $pass,
    'to' => $to,
    'subject' => 'Donation through Bliss19',
    'html' => $message,
    'text' => $message,
    'from' => 'team.bliss19@gmail.com'
);

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
//print_r($response);
////////////////SEND CONFIRMATION TO NGO

$message="<p align=center>****Donation request****</p>You have received a donation request from ".$name.".Please contact them at <br>E-mail:$mail<br>Phone number:$phone ."."<br>Address:".$destination."<br>Date:$date<br>Time:$time<br><br>regards<br>team Bliss";
$params = array(
    'api_user' => $user,
    'api_key' => $pass,
    'to' => $mailngo,
    'subject' => 'Donation through Bliss19',
    'html' => $message,
    'text' => $message,
    'from' => 'team.bliss19@gmail.com'
     );

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
    curl_close($session);
    /////INSERT IN DATABASE
    $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
        if ( sqlsrv_begin_transaction( $conn ) === false ) {
            //die( print_r( sqlsrv_errors(), true );
            //echo "<p>Failed to connect to server..</p>";
    }

    $sql="INSERT INTO mailTime(Email,date,time,sent,ngo) VALUES(?,?,?,?,?)";
    $param=array($mail,$date,$time,0,$namengo);
    $res = sqlsrv_query( $conn, $sql,$param);
    if($res) {
        sqlsrv_commit($conn);
        //echo "1<br>";
        //echo "<p>Registered successfully..</p>";
    }
    $sql="UPDATE all_user_records SET pending=0,result=1,ngomail='$mailngo',ngoname='$namengo',distance_taken='$distance_taken',time_taken='$time_taken' WHERE Email='$mail' AND date='$date' AND time='$time'";
    $res=sqlsrv_query($conn,$sql);
    if($res){
        sqlsrv_commit($conn);
        //echo "2<br>";
    }
    


    $sql="DELETE FROM user_records WHERE Email='$mail' AND date='$date' AND time='$time'";
    $res = sqlsrv_query( $conn, $sql);
    if($res) {
        sqlsrv_commit($conn);
        echo "REQUEST CONFIRMED";
        //echo "<p>Registered successfully..</p>";
    }
    $conn=null;
    
?>