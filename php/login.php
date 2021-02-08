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
      $flag=0;
    $email="";
    $pass="";
    $email_err="";
    $pass_err="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $email=$_POST["username"];
        if (empty($_POST["username"])) {
            $email_err = "Email is required";
          }
          else{
            if(empty($_POST["password"]))
            {
                $pass_err="Enter Password";
            }
            else{
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
    $message11= "Click on the captcha checkbox";
} else {
    if (empty($_POST["username"])) {
        $email_err = "Email is required";
      }
      else {
        $email = test_input($_POST["username"]);
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $email_err = "Invalid email format"; 
         }

      
    if(empty($_POST["password"]))
    {
        $pass_err="Enter Password";
    }
    else{
        $pass=test_input($_POST["password"]);
    

    
    $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        echo "<p>Failed to connect to server..</p>";
   }
    $sql="SELECT Password FROM records WHERE Email='".$email."'";
    $res=sqlsrv_query($conn,$sql);
    while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC))
    {

        $data=$row["Password"];
    }
    
    // if($data === false)
    // {
    //     $message= "email does not exist";
    // }

   if ($data==$pass) {
        $message= "match found";
        $_SESSION['login-mailngo']=$email;
        $_SESSION['login-code']=md5($email);
        ob_start();
        header("Location: http://bliss19.azurewebsites.net/ngo_portal.php");
        ob_end_flush();
        die();
    }
    else {
        $message= "password do not match";
    }
}}}}}}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href='https://fonts.googleapis.com/css?family=Archivo+Black' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Amita|Maiden+Orange' rel='stylesheet'>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="_"
			  crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Here NGOs can login to access their services portal.">
	<title>LOGIN - BLISS</title>
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
                        document.getElementById('para').innerHTML="Invalid Captcha";
                        return false;
                      }
                  }
    </script>
    <script>
        $(function(){
            $(".fa-lock").hover(function(){
                $('#password').attr('type','text');
                $(this).removeClass('fa-lock');
                $(this).addClass('fa-unlock');


            },function(){
                $('#password').attr('type','password');
                $(this).addClass('fa-lock');
                $(this).removeClass('fa-unlock');
            });
        });
    </script>
	<style>
        html{
            height:100;
            width:100%;
        }
        body{
            position: absolute;
            height:100%;
            width:100%;
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
		.container{
			position:absolute;
			top:0;
			height:auto;
			width:100%;
		}
		.img_bcg{
			position:fixed;
			top:0;
			width:59%;
			left:15%;
			height:750px;
            opacity:0.7;

        }
        @media only screen and (max-width:600px){
            .img_bcg{
                width:100%;
                left:0;
                right:0;
            }
        }
		#head{
			background-color:#000080;/*#ff9999;*/
			font-size: 30px;
			color: white;
			font-family: verdana;
            /* border:2px solid dimgrey; */
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:center;
            align-items:center;
        }
		form{
			position:absolute;
			width:49%;
			left:25.5%;
            height:750px;
			background-color: white;
			opacity: 0.85;
            border-radius:15px;
            z-index:10;
		}
        @media only screen and (max-width:600px){
            body{
                margin:0;
                width:100%;
                background-color:lightgrey;
            }
            form{
                width:100%;
                height:100%;
                left:0;
            }
          
        }
		#username{
			border: none;
			border-bottom: 2px solid black;
			opacity: 0.65;
			height: 30px;
			width: 300px;
			font-size: 20px;
		}
		#password{
			border: none;
			border-bottom: 2px solid black;
			opacity: 0.65;
			height: 30px;
			width: 300px;
			font-size: 20px;
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
		.links{
			font-family: 'amita';
			font-weight: bold;
		}
        .link{
            text-decoration: none;
        }
        .link:visited{
            color:black;
        }
        .error{
            color: red;
            font-family:'Maiden Orange';
            text-transform:uppercase;
        }
        .button {
    background-color:blue;
    border: none;
    color: white;
    text-align: center;
    font-size: 16px;
    height: 50px;
    width: 150px;
}
.g-recaptcha{
    opacity:1;
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
<body id="body" onload="f1();">
<br><br>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>


	<img src="backgroundz.png" class="img_bcg" alt="donation_background_image">
	<div class="container">
<center>
<form name="login" style=""  onsubmit="return ValidCaptcha();" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	<div id="head"><br><h1 align="center">LOGIN</h1></div>
	<p class="links"align="right"><a class="link" href=".\verify.php">New Registration</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
	<p align="center" class="error">*<input align="left" type="text" id="username" placeholder="Email ID" name="username" value="<?php echo $email?>"></p><p><span class="error"><?php echo $email_err; ?></span></p>
	<span align="center" class="error">*<input type="password" id="password" placeholder="Password" name="password"></span><i style='position:absolute;right:50px;' class="fas fa-lock"></i><p><span class="error"><?php echo $pass_err; ?></span></p>
    <p class="error"><?php echo $message ?></p>
    <p  class="links"align="right"><a class="link" href=".\email.php">Forgot Password?&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a></p>
    
    <div class="" data-sitekey="_"></div>
    <p id="para" class="error"><?php echo $message11?></p><br>
	<p align="center"><input type="submit" name="submit" class="button" id="submit" value="SIGN IN" ></p><br>
    
</form>
</center>
</div>

</body>
</html> 