<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
      }
    $email="";
    $email_err="";
    $confirm="";
    $email_err1="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
                           // Get resource
$curl = curl_init();

// Configure options, incl. post-variables to send.
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => '_',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        'secret' => '_',
        'response' => $_POST['_']
    )
));

// Send request. Due to CURLOPT_RETURNTRANSFER, this will return reply as string.
$resp = curl_exec($curl);

// Free resources.
curl_close($curl);

// Validate response
if(strpos($resp, '"success": true') == FALSE) {
    $message11= " Not Verified.";
    $flag=1;
} else {
        if (empty($_POST["email"])) {
        $email_err = "Email is required";
        }
        else {
        $email = test_input($_POST["email"]);
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $email_err = "Invalid email format"; 
         }
      }
      $flag=0;
      $pass=rand(100000,999999); 
      $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
     $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
     $serverName = "tcp:_.database.windows.net,1433";
     $conn = sqlsrv_connect($serverName, $connectionInfo);
     if ( sqlsrv_begin_transaction( $conn ) === false ) {
      echo "<p>Failed to connect to server..</p>";
    }
    $check="SELECT Email FROM records WHERE Email='".$email."'";
    $res=sqlsrv_query($conn,$check, array(), array( "Scrollable" => 'static' ));
    if(sqlsrv_num_rows($res)){
    $sql="UPDATE records SET Password='$pass' WHERE Email='$email'";
   $res = sqlsrv_query( $conn, $sql);
   if($res) {
    sqlsrv_commit($conn);
   }
$url = 'https://api.sendgrid.com/';
$user = '_';
$pass1 = '_';
$to=$email;
$message="Your temporary password for BLISS.. is <b>".$pass."</b>.<br>We recommend you to change this temporary password by going to the link below.<br><br>http://bliss19.azurewebsites.net/login.php";
$params = array(
     'api_user' => $user,
     'api_key' => $pass1,
     'to' => $to,
     'subject' => 'Temporary Password',
     'html' => $message,
     'text' => $message,
     'from' => 'team@bliss19.azurewebsites.net'
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
}
elseif($email_err==""){
    $email_err1="Email does not exist";
    $flag=1;
}}}
    ?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta 
     name='viewport' 
     content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' 
/>
  <title>Forgot Password</title>
  <meta name="description" content="Here you can reset your password.">
    <link href='https://fonts.googleapis.com/css?family=Archivo Black' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Allan' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Acme' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Baloo' rel='stylesheet'>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  <style>
     

      html{
          height:100%;
      }
      body{
          height:100%;
          margin:0;
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
            width: 45%;
            height: 600px;
            left: 26.5%;
            background-color: rgba(243, 242, 243,1);
            top: 8%;
            opacity: 0.72;
            border-radius: 15px;
    }
    @media only screen and (max-width: 600px) {
   form{
       position:absolute;
       width:100%;
       left:0;
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
      background-color:#cc0000;
      font-size: 250%;
      color: white;
      font-family: verdana;
            margin: 0;
            height: 22%;
            font-weight: bold;
            position: absolute;
            width: 100%;
            border-radius: 15px 15px 0px 0px;
    }
        body{
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
            top: 22%;
            left: 12.5%;
            right:12.5%;
            height: 80%;
            width: 80%;
            bottom: 4%;
        }
        .img{
        position:fixed;
        top:0;
        left:0;
          height:100%;
          width: 100%;
          opacity: ;
        }
    </style>
    <script>
    var a;
    function f1(){
      a=Math.floor(Math.random()*9000+1000);
      document.getElementById('pr').innerHTML=a;
    }
    function ValidCaptcha(){
                      var string1 =a;
                      var string2 =parseInt(document.getElementById('captcha').value);
                      if (string1 == string2){
                        return true;
                      }
                      else{        
                        alert("Invalid Captcha");
                        return false;
                      }
                  }
  </script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
<script>
  
  
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});
});

</script>  
</head>
<body onload="f1();"> 
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
<img src="./pass-back.jpg" class="img" alt="background_image">
<br>
<center>
<form name="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" onsubmit="return ValidCaptcha();">
<div id="head">
<p> FORGOT PASSWORD</p>
</div>
<div id="body">
<p class="input">INPUT &nbsp REGISTERED &nbsp EMAIL-ID</p>
<input type="text" name="email" id="text" placeholder="Registered email ID"><p class="error"><?php echo $email_err; if($flag==1) echo $email_err1;?></p> <br>
<div class="_" data-sitekey="_"></div>
<p id="para" class="error"><?php echo $message11?></p><br>
    <input type="submit" class="button" value="SUBMIT"><br>
    <p id="message">A link will be sent to your registered e-mail having a temporary password.<br>We strongly recommend you to change this password by going to the link given there.</p>
    <p class="confirm" id="confirm"><?php if($flag==0)echo $confirm;?></p>
    </div>
</form>
</center>
</body>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST" && $flag==0 && $email_err=="")
{  
?>
<meta http-equiv="Refresh" content="7;url=.\login.php">
<?php
}
?>
</html>