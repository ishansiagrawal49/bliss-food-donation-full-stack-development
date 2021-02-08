<?php
session_start();
?>
<?php
  function take_input($data)
  {
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
  }
  $email2="";
  $flag=0;
  if(take_input($_SESSION['ngo-portal-flag'])==1){
    $flag=1;
     $code=take_input($_SESSION['login-code']);
     $mail1=take_input($_SESSION['login-mailngo']);
    $check=$mail1;
    $check=md5($check);
    if($code==$check){
      $email2=$mail1;
  }}
  if(($email2=="") && $_SERVER["REQUEST_METHOD"]!="POST")
  {
    ob_start();
    header("Location: login.php");
    ob_end_flush();
    die();
  }
  $name=$mail=$gender=$phone=$pass=$pass2=$address=$city=$state="";
  $nameErr=$mailErr=$genderErr=$phoneErr=$passErr=$addressErr=$cityErr=$stateErr="";
  $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
        
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
  $connectionInfo = array("UID" => "_ "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
 $serverName = "tcp:_.database.windows.net,1433";
 $conn = sqlsrv_connect($serverName, $connectionInfo);
 if ( sqlsrv_begin_transaction( $conn ) === false ) {
  echo "<p>Failed to connect to server..</p>";
}
else{
   
}
if(!($_SERVER["REQUEST_METHOD"]=="POST"))
{
$sql1="SELECT * FROM records WHERE Email='".$email2."'";
$data1=sqlsrv_query($conn,$sql1);
$row=sqlsrv_fetch_array($data1,SQLSRV_FETCH_ASSOC);
$name1=$row['name'];
$email1=$row['Email'];
$password1=$row['Password'];
$mobile1=$row['Mobile'];
$address1=$row['Address'];
$city1=$row['city'];
$state1=$row['state'];
}
if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if(empty($_POST["txtName"])){
      $nameErr="Username field cannot be empty";
    }
    else {
      $name=take_input($_POST["txtName"]);
      if(!preg_match("/^[a-zA-Z0-9 ]{3,50}$/",$name))
      {
        $nameErr="Please provide a valid username";
        $name="";
      }

    }
    if(empty($_POST["txtMail"]))
    {
      $mailErr="E-mail field cannot be left empty";
      $mail="";
    }
    else {
      $mail=($_POST["txtMail"]);
    }
    $pass=($_POST["pass"]);
    $pass2=($_POST["CnfPass"]);
    if(empty($pass)||empty($pass2))
    {
	$passErr="Password/Confirm Password left empty";
    $pass=$pass2="";    
    }
    elseif($pass!=$pass2)
    {
	$passErr="Passwords do not match";
    $pass=$pass2="";
    }
    else{
        if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/",$pass)){
            $passErr="Please Enter a valid Password";
            $pass=$pass2="";
        }
    }
    $phone=$_POST["phone"];
    if(strlen($phone)<10)
    {
	$phoneErr="Please Enter a valid Phone Number";
    $phone="";
    }
    $address=$_POST["address"];
    if(empty($address))
    {
	$addressErr="Address cannot be left empty";
    $address="";
    }
    $city=$_POST["city"];
    if(empty($city))
    {
	$cityErr="city field cannot be left empty";
    $city="";
    }
    $state=$_POST["state"];
    if(empty($state))
    {
    $stateErr="state field cannot be left empty";
    $state="";
    }
    $email2=$_POST["email2"];
  }

?>
<html>
<head>
  <title>
    Update Info - BLISS
  </title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="style_login.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script></script><script  defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyB0WxLMoI0Pzj7u4IxbKBBUdZtzrDW2Q4M"  type="text/javascript"></script>
<meta name="description" content="Here registered NGOs can update their information they have provided the BLISS earlier.">
<script src="register.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rakkas" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange|Righteous" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'> 
<link rel="stylesheet" href="http://resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='picker_city.js' type='text/javascript'></script>
<script>

  
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});
});
</script> 
  <script>
  $( function() {
    $( document ).tooltip();
  } );
  </script> 
  <style>
      #logout-button{
    position: absolute;
    z-index: 60;
    top: 5%;
    right: 2%;
    text-transform: uppercase;
    font-family: ABeeZee;
    border:2px solid #227093;
    background-color:blue;
    color:whitesmoke;
    font-size:15px;
    height: 35px;
    border-radius: 10px;
}
#logout-button:hover{
    background-color:white;
    color:blue;
}
  </style>
<script>
$(function(){
    var citydup=availabletags2;
            for(i=0;i<citydup.length;i++){
                citydup[i]=citydup[i].toLowerCase();
            }
            var statedup=availableTags;
            for(i=0;i<statedup.length;i++){
                statedup[i]=statedup[i].toLowerCase();
            }
            setInterval(function(){
                var text=$("#address").val();
                if($.trim(text)!='')
                {
                array=text.split(',');
                for(i=0;i<array.length;i++){
                    array[i]=$.trim(array[i]);
                    var length=array[i].length;
                    
                    // for(j=length-1;j>=0;j--){
                    //     if(array[i].charAt(j)===' '){
                    //         length=length-1;
                    //     }
                    //     array[i]=array[i].substring(0,length);
                    // }
                    }
                    l=array.length;
                    var city_fill=array[l-3];
                    var state_fill=array[l-2];
                    if($.inArray(city_fill.toLowerCase(),citydup)!=-1){
                        $("[name='city']").val(city_fill);
                   
                    }
                    else{
                    $("[name='city']").val('');
                    }

                      if($.inArray(state_fill.toLowerCase(),statedup)!=-1){
                        $("[name='state']").val(state_fill);
                   
                    }
                    else{
                    $("[name='state']").val('');
                    }
                    


                
                }
            },100);
          
    $("#submit").click(function(event){
         email_old="<?php echo $email2;?>";
         email_new=$("[name='txtMail']").val();
         if(email_new!=email_old){
             var r=confirm("Are you sure you want to change Your Email Address?");
             if(r==true){

             }
             else{
                $("[name='txtMail']").val(email_old);
                 event.preventDefault();
             }
         }

    });
});
</script>
</head>
<body> 
<a href="https://bliss19.azurewebsites.net/frontIndex.html" style="text-decoration:none;"><input type="button" id="logout-button" value="LOG OUT"></a>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="https://media.giphy.com/media/N256GFy1u6M6Y/giphy.gif" class="image_load">
</div>
<div class="container">
<h1 class="heading2">Update Information</h1>
  
<p class="error"><?php echo $error ?></p>

<center>  <form class="box" name="register"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
<table>
<tr>
  <td>Name Of NGO/Organisation:</td><td><input type="text" name="txtName" title="Please Enter more than 3 characters.You can alphabets,digits,'.'and '-'"placeholder="Enter your name" value="<?php if(!isset($_POST['submit']))echo $name1;else echo $name;?>"/><span>*<?php echo $nameErr;?></span></td><br>
</tr>
<tr>
<td>
 E-mail:</td><td><input type="text" name="txtMail" placeholder="Enter your e-mail ID" readonly value="<?php if(!isset($_POST['submit']))echo $email1; else echo $mail?>"/><span>*<?php echo $mailErr;?></span></td></tr><br>
<tr>
  <td>Password:</td><td><input placeholder="Enter your password" title="Minimum 6 characters with atleast one character and digit" type="text" name="pass" value="<?php if(!isset($_POST['submit']))echo $password1;else echo $pass;?>"><span>*<?php echo "{$passErr}" ?></span></td></tr><br>
<tr><td>
Confirm Password:</td><td><input placeholder="Confirm Your Password" type="text" name="CnfPass" value="<?php if(!isset($_POST['submit']))echo $password1;else echo $pass2?>"><span>*</span></tr></td><br>
<tr><td>
Address:</td>
<td>
<input type="text" id="address" name="address" placeholder="Enter your address" value="<?php if(!isset($_POST['submit']))echo $address1;else echo $address;?>"/><span>*<?php echo $addressErr;?></span></td></tr><br>
<input type="hidden" id="origin">
<tr>
<td>City:</td>

<td><input type="text" name="city" id="city" placeholder="Enter your city" value="<?php if(!isset($_POST['submit']))echo $city1;echo $city;?>"/><span>*<?php echo $cityErr;?></span></td></tr><br>
<tr>
<td>State:</td>

<td><input type="text" name="state" id="state" placeholder="Enter your state" value="<?php if(!isset($_POST['submit']))echo $state1;echo $state;?>"/><span>*<?php echo $stateErr;?></span></td></tr><br>

<tr><td>
Mobile:</td><td><input type="text" placeholder="Enter your contact number" value="<?php if(!isset($_POST['submit']))echo $mobile1 ;else echo $phone;?>" name="phone"><span>*<?php echo $phoneErr;?></span></td></tr></table>
<br>
<input type="hidden" name="email2" value="<?php echo $email2;?>">  
<input type="submit" value="SUBMIT" name="submit" id="submit">
  
</form></center>
</div>
<?php
$flag=0;
if($nameErr==""&&$mailErr==""&&$phoneErr==""&&$passErr==""&&$addressErr==""&&$cityErr==""&&$stateErr==""&&isset($_POST["submit"]))
{
    $flag=1;
   $sql="UPDATE records SET name='$name',Email='$mail',Password='$pass',Address='$address',Mobile='$phone',city='$city',state='$state' WHERE Email='$email2'";
  
   $res = sqlsrv_query( $conn, $sql);
   if($res) {
    sqlsrv_commit($conn);
    echo "<p>Updated successfully..</p>";
    ?>
    <meta http-equiv="Refresh" content="2;url=login.php">
<?php
} 
else
{
    die( print_r( sqlsrv_errors(), true ));
    echo "Failed to register.Please Try again later";
}

}
?>
</body>
</html>

