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
$email=$_SESSION['verify-email'];
$data=$_SESSION['verify-pass'];
$otp_err="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $pass=md5(test_input($_POST["password"]));
    $data=(test_input($_POST["pass"]));
    $email=test_input($_POST['email']);
    $code=$email."2806";
    $code=md5($code);
    $_SESSION['otp-email']=$email;
    $_SESSION['otp-code']=$code;
    $_SESSION['otp-flag']=1;
    if($pass==$data){
        ob_start();
        header("Location: http://bliss19.azurewebsites.net/register.php");
        ob_end_flush();
        die();
    }
    elseif($pass=="_"){
        $otp_err="Please enter OTP";
    }
    else{
        $otp_err="OTP does not match";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>E-Mail Verification</title><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Enter the OTP that you have recieved by bliss team.">
    <link href='https://fonts.googleapis.com/css?family=Archivo Black' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Allan' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Acme' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Baloo' rel='stylesheet'>
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
            font-size:21px;
            border: none;
            border-bottom: 2px solid black;
            background-color: rgba(243, 242, 243,0.8);
            font-family: arial;
            text-align: left;
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
            top: 28%;
            left: 11.5%;
            right:14.5%;
            height: 80%;
            width: 80%;
            bottom: 4%;
        }
        .img{
          height: 100%;
          width: 100%;
          opacity:0.5 ;
        }
        #par{
            position: absolute;
            left: 7%;
            top: 25%;
        }
        #par1{
            position: absolute;
            left: 7%;
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
    <img src="loading1.gif" class="image_load" >
</div>
<img src="abstract.jpg" class="img" alt="background_image">
<br>
<center>
<form name="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
<div id="head">
<p> E-MAIL VERIFICATION</p>
</div>
<div id="body"><br>
<p class="error" id="par1">*</p><p id="text"><?php echo $email?></p><br>
<p class="error" id="par">*</p><input type="password" name="password" placeholder="Enter OTP" id="pass"><br><p class="error">&nbsp <?php echo $otp_err;?></p><br>
<input type="hidden" name="pass" value="<?php echo $data ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
<input type="submit" class="button" value="SUBMIT"><br>
<p id="message">An OTP will be sent to your e-mail.<br>
Enter the OTP here to get registered.</p>
</div>
</form>
</center>
</body>
</html>