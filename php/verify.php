<?php
session_start();
?>
<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
  }
  $email="";
  $email_err="";
  $flag=0;
  $pass=0;
  $confirm="";
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if (empty($_POST["email"])) {
      $email_err = "Email is required";
      $flag=1;
      }
      else {
      $email = test_input($_POST["email"]);
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $email_err = "Invalid email format"; 
         $flag=1;
       }
    }
    $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
     $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
     $serverName = "tcp:_.database.windows.net,1433";
     $conn = sqlsrv_connect($serverName, $connectionInfo);
     if ( sqlsrv_begin_transaction( $conn ) === false ) {
      echo "<p>Failed to connect to server..</p>";
    }
    $sql="SELECT Email FROM records WHERE Email='".$email."'";
    $data=sqlsrv_query($conn,$sql,array(),array("scrollable" => "static"));
    if((sqlsrv_num_rows($data)==0) && $flag==0){
        $pass=rand(100000,999999);
        $url = 'https://api.sendgrid.com/';
$user = '_';
$pass1 = '_';
$to=$email;
$message="Your one time password for BLISS.. is <b>".$pass."</b>.
<br>Enter the OTP to get register yourself with BLISS.<br><br>Regards,<br>Team BLISS";
$params = array(
     'api_user' => $user,
     'api_key' => $pass1,
     'to' => $to,
     'subject' => 'OTP for registration',
     'html' => $message,
     'text' => $message,
     'from' => 'team@bliss19.azurewebsites.net',
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
$confirm="Mail has been sent";
$data=md5($pass);
$_SESSION['verify-pass']=$data;
$_SESSION['verify-email']=$email;
ob_start();
header("Location: http://bliss19.azurewebsites.net/otp.php");
ob_end_flush();
die();
    }
    elseif($flag==0){
        $email_err="Already Registered";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>E-Mail Verification - BLISS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="NGOs have to get their e-mail verified here ">
    <link href='https://fonts.googleapis.com/css?family=Archivo Black' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Allan' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Acme' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Baloo' rel='stylesheet'>
  <style>

      html{  
          height:100%;
      }    
      body{
          margin:0;
          height:100%;
      }
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
    form{
        position: absolute;
        width: 40%;
        height: 490px;
        left: 30%;
        background-color: rgba(243, 242, 243,1);
        top: 12%;
        opacity: 0.8;
        border-radius: 10px;
    }
    @media only screen and (max-width: 600px) {
   form{
       position:absolute;
       width:80%;
       top:5%;
       height:500px;
       left:10%;
   }
}
        #captcha{
      border: 2px solid black;
      opacity: 0.65;
      font-size: 30px;
      height: 40px;
      width: 100px;
      text-align: center;
        }
        #p1{
      font-family: 'Archivo Black';
      font-size: 20px;
        }
        #pr{
      font-weight: bold;
      font-family: 'Archivo Black';
      font-size: 20px;
      border-style: solid;
      border-color: black;
      background-color: white;
      width: 100px;
        }
        .confirm{
            font-family: Baloo;
            font-size: 30px;
        }
        #head{
      background-color:black;
      font-size: 250%;
      color: white;
      font-family: verdana;
            margin: 0;
            height: 28%;
            font-weight: bold;
            position: absolute;
            width: 100%;
            border-radius: 10px 10px 0px 0px;
    }
        .input{
            font-size: 25px;
            font-family: Allan;
        }
        #text{
            height: 30px;
            width: 80%;
            font-size:20px;
            border: none;
            border-bottom: 2px solid black;
            background-color: rgba(243, 242, 243,0.8);
        }
        #pass{
           height: 30px;
            width: 40%;
            font-size:20px;
            border: none;
            border-bottom: 2px solid black;
            background-color: rgba(243, 242, 243,0.8);
            position: absolute;
            left: 10%;
        }
        .button {
        background-color:blue;
        border: 2px solid black;
        color: white;
        text-align: center;
        font-size: 20px;
        height: 50px;
        width: 150px;
        font-family: verdana;
        }
        #message{
            font-family: Acme;
            font-size: 15px;
            align: justify;
        }
        .error{
            color: red;
            font-family: comic sans ms;
        }
        #body{
            position: absolute;
            top: 29%;
            left: 11.5%;
            right:14.5%;
            height: 80%;
            width: 80%;
            bottom: 4%;
        }
        .img{
          height: 100%;
          width: 100%;
          opacity: 0.5;
        }
    </style>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
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
<img src="abstract.jpg" class="img" alt="background_image">
<br>
<center>
<form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
<div id="head">
<p> E-MAIL VERIFICATION</p>
</div>
<div id="body"><br>
<p class="error">*<input type="text" name="email" id="text" placeholder="E-Mail ID"></p><p class="error"><?php echo $email_err;?></p><br><br>
<input type="submit" class="button" value="SEND" name="submit"><br>
<p id="message">An OTP will be sent to your e-mail ID.<br>
Enter the OTP here to get registered with us.</p>
</div>
</form>
</center>
</body>
</html>
