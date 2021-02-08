<?php
if(!isset($_POST['submit'])){
    $name=$_GET['name'];
    $address=$_GET['address'];
    $phone=$_GET["phone"];
$mail=$_GET['mail'];
$date=$_GET['date'];
$time=$_GET['time'];
$city=$_GET['user_city'];
$distancetaken=$_GET['distancetaken'];
$timetaken=$_GET['timetaken'];
$ngoname=$_GET['ngoname'];
$ngomail=$_GET['ngomail'];
$ngophone=$_GET['ngophone'];
$ngoaddress=$_GET['ngoaddress'];
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
            $sql="SELECT pending,result FROM all_user_records WHERE name='$name' AND Email='$mail' AND date='$date' AND time='$time'";
            $res=sqlsrv_query($conn,$sql);
            
            while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
                $pending=$row['pending'];
                $result=$row['result'];
            }
            settype($pending,'int');
            settype($result,'int');
            if($pending==0){
                if($result==0){
                die("THIS REQUEST IS ALREADY CONFIRMED");
                }
                else{
                    die("THIS REQUEST IS ALREADY REJECTED");
                }
            }
}
else{
    $ngoname=$_POST['ngoname'];
    $ngomail=$_POST['ngomail'];
    $ngophone=$_POST['ngophone'];
    $ngoaddress=$_POST['ngoaddress'];
    $address=$_POST['address'];
    $phone=$_POST["phone"];
    $city=$_POST['city'];
    $mail=$_POST['mail'];
    $date=$_POST['date'];
    $time=$_POST['time'];
    $name=$_POST['name'];
    //////////////////////////////////////
    if($_POST["option"]=="yes"){
        //SEND CONFIRMATION MAIL TO USER
        $url = 'https://api.sendgrid.com/';
        $user = '_';
        $pass = '_';
        $message="<p align=center>****Donation confirmation mail****</p>Your donation is accepted by ".$ngoname.".<br>You can contact them at <br>E-mail ID:".$ngomail."<br>phone number:".$ngophone."<br>Address:".$ngoaddress."<br>Keep Donating!!<br><br>Regards,<br>team Bliss";
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

        $message="<p align=center>****Donation Request****</p>You have received a donation request from ".$name.".Please contact them at E-mail:$mail<br>Phone number:$phone ."."<br>Address:".$address."<br>Date:$date<br>Time:$time";
        $params = array(
            'api_user' => $user,
            'api_key' => $pass,
            'to' => $ngomail,
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
            $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
            $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
            $serverName = "tcp:_.database.windows.net,1433";
            $conn = sqlsrv_connect($serverName, $connectionInfo);
                if ( sqlsrv_begin_transaction( $conn ) === false ) {
                    //die( print_r( sqlsrv_errors(), true );
                    //echo "<p>Failed to connect to server..</p>";
            }

            $sql="INSERT INTO mailTime(Email,date,time,sent,ngo) VALUES(?,?,?,?,?)";
            $param=array($mail,$date,$time,0,$ngoname);
            $res = sqlsrv_query( $conn, $sql,$param);
            if($res) {
                sqlsrv_commit($conn);
            }
            $sql="UPDATE all_user_records SET pending=0,result=1,ngomail='$ngomail' WHERE Email='$mail' AND date='$date' AND time='$time'";
            $res=sqlsrv_query($conn,$sql);
            sqlsrv_commit($conn);
            $conn=null;
            die("REQUEST CONFIRMED");
    }
    else{
        $url = 'https://api.sendgrid.com/';
        $user = '_';
        $pass = '_';
        $message="<p align=center>****reject request mail****</p>This is to inform you that your preffered NGO has rejected your request. Now your donation request is open to all NGOs in the city. We will get to you as soon as we get an NGO for your request.";
        $params = array(
            'api_user' => $user,
            'api_key' => $pass,
            'to' => $mail,
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

                $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
                $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
                $serverName = "tcp:_.database.windows.net,1433";
                $conn = sqlsrv_connect($serverName, $connectionInfo);
                    if ( sqlsrv_begin_transaction( $conn ) === false ) {
                        //die( print_r( sqlsrv_errors(), true );
                }
                else{
                  
                }
                $sql="INSERT INTO user_records(name,Email,address,phone,date,time,city) VALUES(?,?,?,?,?,?,?)";
                $param=array($name,$mail,$address,$phone,$date,$time,$city);
                $res = sqlsrv_query( $conn, $sql,$param);
                if($res){    
                sqlsrv_commit($conn);
                }
                else{
                    die( print_r( sqlsrv_errors(), true ));
                }
               
                $sql="UPDATE all_user_records SET pending=0,result=0 WHERE Email='$mail' AND date='$date' AND time='$time'";
                $res=sqlsrv_query($conn,$sql);
                sqlsrv_commit($conn);


    }
    ?>
    <meta http-equiv="Refresh" content="2;url=frontIndex.html">
    <?php
}

?>
<html>
<head>
<title>
Donation Request Confirmation - BLISS 
</title>
<meta name="description" content="Through this, NGOs can handle the donation requests using mail.">
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet"> 
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>

<style>
.image_cont{
    width:100%;
    height:100%;
    position:fixed;
    top:0;
    left:0;
    z-index:100;
    background-color:rgba(255,255,255,1);
    border:2px solid;
  }

  .cont-cont{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background-color:black;
    /* background-color: rgba(255,255,255,0.98); */
   z-index:100;
  }
  .image_load{
    /* width:64px;
    height:64px; */
    height:30vh;
    width:25%;
    position:fixed;
    /* left:45%;
    top:45%; */
    left:37.5%;
    top:35vh;
    z-index:100;
  } 
body{
    /* background-color:#b33939; */
    background: #a73737;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #7a2828, #a73737);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #7a2828, #a73737); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
form{
    position:absolute;
    top:10%;
    left:20%;
    width:60%;
    text-align:center;
    background-color:#f7f1e3;
    box-shadow: 0 4px 8px 0 rgba(0, 0,0, 0.5), 0 6px 20px 0 rgba(0,0, 0, 0.49);
}
input[type='text']{
    border:2px solid #f7f1e3;
    height:30px;
    width:60%;
}
.header{
    text-transform:uppercase;
    font-family:'Righteous';
    
}
.options{
    font-family:'Maiden Orange',cursive;
    color:maroon;
    font-size:20px;
}
input[type='submit']{
    background-color:blue;
    width:100px;
    height:50px;
    color:white;
    text-transform:uppercase;
    font-family:'Righteous';
    border:2px solid black;
}
.para{
    color:#ecf0f1;
    font-size:20px;
    font-family: 'Ubuntu Condensed', sans-serif;
    text-align:center;
}
</style>
<script>
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});


});

</script> 
</head>
<body>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
<p  class="para">Here is the information of the user who wants to donate to your 
    NGO/Organisation.If you wish to accept the request select option yes and submit.
    Else select NO.
</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<br>
<span class="header">Name:</span><br><br><input name="name" type="text" value="<?php echo $name?>" readonly><br>
<span class="header">Mail:</span><br><br><input name="mail" type="text" value="<?php echo $mail?>" readonly><br>
<span class="header">Phone:</span><br><br><input name="phone" type="text" value="<?php echo $phone?>" readonly><br>
<span class="header">Address:</span><br><br><input name="address" type="text" value="<?php echo $address?>" readonly><br>
<span class="header">Date:</span><br><br><input name="date" type="text" value="<?php echo $date?>" readonly><br>
<span class="header">Time:</span><br><br><input name="time" type="text" value="<?php echo $time?>" readonly><br>
<span class="header">Distance:</span><br><br><input type="text" value="<?php echo $distancetaken?>" readonly><br>
<span class="header">Time to reach:</span><br><br><input type="text" value="<?php echo $timetaken?>" readonly><br>
<span class="header">Do you want to accept  the request?</span><br><br>
<input type="radio" name="option" value="yes" checked><span class="options">YES</span><br>
<input type="radio" name="option" value="no"><span class="options">NO</span><br>
<input type="hidden" name="ngoname" value="<?php echo $ngoname?>">
<input type="hidden" name="ngomail" value="<?php echo $ngomail?>">
<input type="hidden" name="ngophone" value="<?php echo $ngophone?>">
<input type="hidden" name="ngoaddress" value="<?php echo $ngoaddress?>">
<input type="hidden" name="city" value="<?php echo $city?>">
<br><br>
<input type="submit" value="submit" name="submit">

</form>
</body>
</html>