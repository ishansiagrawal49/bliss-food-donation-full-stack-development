<?php
header("Access-Control-Allow-Origin:*");

// $ngo=$_GET["name"];
// $email_ngo=$_GET["mail"];
// $phone_ngo=$_GET["phone"];
// $address_ngo=$_GET["destination"];
// $address_user=$_GET["origin"];
// $distance_taken=$_GET["distance_taken"];
// $time_taken=$_GET["time_taken"];
// $user_city=$_GET['city'];


$ngoname=$_GET["name"];
$ngoemail=$_GET["mail"];
$phonengo=$_GET["phone"];
$ngoaddress=$_GET['destination'];
$useraddress=$_GET['origin'];
$user_city=$_GET['city'];
$url = 'https://api.sendgrid.com/';
$user = 'api_key';
$pass = 'password';
$to=$_POST["user_mail"];
$date=$_POST['date'];
$time=$_POST['time'];
$distance_taken2=$_GET['distance_taken'];
$time_taken2=$_GET['time_taken'];
//$$$$$$$$$$$$$$$$$$$$$$$$ SEND MAIL TO USER $$$$$$$$$$$$$$$$$$$$

//////////////////$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$//////////////////////////


$user_name=$_POST["user"];
$user_mail=$_POST["user_mail"];
$user_phone=$_POST["user_phone"];

/*Check date*/


//$message="You have received a donation request from ".$user_name.".Please contact them at E-mail:$user_mail or phone number:$user_phone ."."\nAddress:".$useraddress;
$message_html=$message."<p align=center>****Donation request mail****</p>
<p>Donor: $user_name</p>
<p>Date: $date $time</p>
<p>Address: $useraddress</p>
<p>Phone no.: $user_phone</p>
<p>If you are intereseted click on confirm below.<br>
<a href='http://bliss19.azurewebsites.net/mail_confirmation.php?address=$useraddress&name=$user_name&mail=$user_mail&user_city=$user_city&phone=$user_phone&date=$date&time=$time&distancetaken=$distance_taken2&timetaken=$time_taken2&ngoname=$ngoname&ngomail=$ngoemail&ngophone=$phonengo&ngoaddress=$ngoaddress'><b>CONFIRM</b></a></p>";
$params = array(
     'api_user' => $user,
     'api_key' => $pass,
     'to' => $ngoemail,
     'subject' => 'Donation through Bliss19',
     'html' => $message_html,
     'text' => $message_html,
     'from' => 'team.bliss19@gmail.com'
  );
  echo $ngoemail;
$request = $url.'api/mail.send.json';

//Generate curl request
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

// print everything out
print_r($response);


//$$$$$$$$$$$$$$$$$$Inserting date and time$$$$$$$$$$$$$$$$$$$$$$$


$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database =_", "_", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true );
        echo "<p>Failed to connect to server..</p>";
   }
   else{
   }

    $sql="INSERT INTO all_user_records(name,Email,date,time,phone,address,ngoname,ngomail,pending,result,city,distance_taken,time_taken) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $param=array($user_name,$user_mail,$date,$time,$user_phone,$useraddress,$ngoname,$ngoemail,1,0,$user_city,$distance_taken2,$time_taken2);
   $res = sqlsrv_query( $conn, $sql,$param);
   if($res) {
    
    sqlsrv_commit($conn);
    echo "my name is ?????";
    ?>
    
    <!-- <meta http-equiv="Refresh" content="6;url=frontIndex.html"> -->
    <?php
   }



?>