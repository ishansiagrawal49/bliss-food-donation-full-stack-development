<?php
session_start();
?>
<html>
<head>
  <title>
    Registration Form - Bliss
  </title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="style_login.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script></script><script  defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyB0WxLMoI0Pzj7u4IxbKBBUdZtzrDW2Q4M"  type="text/javascript"></script>
<meta name="description" content="Here any NGOs can register themselves with BLISS.">
<script src="register.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rakkas" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange|Righteous" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="http://resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="passfield.js"></script>
  <script src='picker_city.js' type='text/javascript'></script>
<link rel="stylesheet" href="passfield.css"/>
<script>
  
  
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});
$("[type='text'],[type='password']").focusin(function(){
        $(this).css({
            "border-bottom":"2px solid blue"
        })
    });
    $("[type='text']").focusout(function(){
        $(this).css({
            "border-bottom":"2px solid #227093"
        })
    });
});

</script>  
  <script>
  $( function() {
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
  
    $(document).tooltip();
  
  } );
  </script>
</head>
<body> 
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
<div class="container">
<h1 class="heading2">Register</h1>

  <?php
  function take_input($data)
  {
    $data=trim($data);
    $data=stripslashes($data);
    return $data;
  }
  $mail="";
  $flag=0;
  if(take_input($_SESSION['otp-flag'])==1){
    $flag=1;
     $code=take_input($_SESSION['otp-code']);
     $mail1=take_input($_SESSION['otp-email']);
    $check=$mail1."2806";
    $check=md5($check);
    if($code==$check){
      $mail=$mail1;
  }}
  if(($mail=="") && $_SERVER["REQUEST_METHOD"]!="POST")
  {
      ob_start();
      header("Location: verify.php");
      ob_end_flush();
      die();
  }
  $name=$gender=$phone=$pass=$pass2=$address=$city=$state="";
  $nameErr=$mailErr=$genderErr=$phoneErr=$passErr=$addressErr=$cityErr=$stateErr="";
  //
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if(empty($_POST["txtName"])){
      $nameErr="Username field cannot be empty";
    }
    else {
      $name=take_input($_POST["txtName"]);
      //echo $name."*******************<br>";
      if(!preg_match("/^[a-zA-Z0-9 -.]{3,50}$/",$name))
      {
        $nameErr="Please provide a valid username";
        $name="";
      }

    }
    if(empty($_POST["txtMail"]))
    {
      $mailErr="E-mail field cannot be left empty";
    }
    else {
      $mail=($_POST["txtMail"]);
    }
    $pass=($_POST["pass"]);
    $pass2=($_POST["CnfPass"]);
    if(empty($pass)||empty($pass2))
    {
	$passErr="Password/Confirm Password left empty";
    }
    elseif($pass!=$pass2)
    {
	$passErr="Passwords do not match";
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
    }
    $address=$_POST["address"];
    if(empty($address))
    {
	$addressErr="Address cannot be left empty";
    }
    $city=$_POST["city"];
    if(empty($city))
    {
	$cityErr="city field cannot be left empty";
    }
    $state=$_POST["state"];
    if(empty($state))
    {
	$stateErr="state field cannot be left empty";
    }

   /* if(!isset($_POST["gender"]))
    {
      $genderErr="Please select a gender";
    }
    else
    {
        $gender=($_POST["gender"]);
    }*/


  }

?>
<center>  <form class="box" name="register"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
<img src="images.png" class="images">
<table>
<tr>
  <td>Name Of NGO/Organisation:</td><td><input type="text" name="txtName" title="Please Enter more than 3 characters.You can include alphabets,digits,'.'and '-'" placeholder="Enter your name" value="<?php echo $name?>"/><span>*<?php echo $nameErr;?></span></td><br>
</tr>
<tr>
<td>
 E-mail:</td><td><input type="text" name="txtMail" placeholder="Enter your e-mail ID" value="<?php echo $mail;?>" readonly/><span>*<?php echo $mailErr;?></span></td></tr><br>
<tr>
  <td>Password:</td><td><input placeholder="Enter your password" title="Minimum 6 characters with atleast one character and digit" type="password" name="pass" <?php if($passErr=='')echo "value='{$pass}'";?>><span>*<?php echo "{$passErr}" ?></span></td></tr><br>
<tr><td>
Confirm Password:</td><td><input placeholder="Confirm Your Password" type="password" name="CnfPass" <?php if($passErr=='')echo "value='{$pass}'";?>><span>*</span></tr></td><br>
<tr><td>
Address:</td>
<td>
<input type="text" id="address" name="address" placeholder="Enter your address" value="<?php echo $address;?>"/><span>*<?php echo $addressErr;?></span></td></tr><br>
<input type="hidden" id="origin">
<tr>
<td>City:</td>

<td><input type="text" name="city" id="city" placeholder="Enter your city" value="<?php echo $city;?>"/><span>*<?php echo $cityErr;?></span></td></tr><br>
<tr>
<td>State:</td>

<td><input type="text" name="state" id="state" placeholder="Enter your state" value="<?php echo $state;?>"/><span>*<?php echo $stateErr;?></span></td></tr><br>

<tr><td>
Mobile:</td><td><input type="text" placeholder="Enter your contact number" value="<?php echo $phone ;?>" name="phone"><span>*<?php echo $phoneErr;?></span></td></tr></table>
<!--Gender:<span>*<?php echo $genderErr;?></span><br>
  <input type="radio" name="gender" value="Male" <?php if(isset($_POST["gender"])&&$gender=="Male")echo "checked"?>>Male<br>
  <input type="radio" name="gender" value="Female" <?php if(isset($_POST["gender"])&&$gender=="Female")echo "checked"?>>Female<br>
  -->
<br>
  <input type="submit" value="SUBMIT" name="submit" id="submit">
</form></center>
</div>
<?php
$flag=0;
if($nameErr==""&&$mailErr==""&&$phoneErr==""&&$passErr==""&&$addressErr==""&&$cityErr==""&&$stateErr==""&&isset($_POST["submit"]))
{
    /*$flag=1;
    $host="tcp:tharwani.database.windows.net,1433";
    $dbuser="tharwani@tharwani";
    $dbpass="welcome@123";
    $dbname="MySql_database";
    $conn=mysqli_connect($host,$dbuser,$dbpass,$dbname);
    if(mysqli_connect_errno())
    {
      die("could not connect to database!".mysqli_connect_error());
    }
    else{
        echo "connected";
    }*/
    $flag=1;
        $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        echo "<p>Failed to connect to server..</p>";
   }

   $sql="INSERT INTO records (name,Email,Password,Address,Mobile,city,state) VALUES(?,?,?,?,?,?,?)";
   $param=array($name,$mail,$pass,$address,$phone,$city,$state);
   $res = sqlsrv_query( $conn, $sql,$param);
   if($res) {
    sqlsrv_commit($conn);
    echo "<p>Registered successfully..</p>";
    ?>
    <meta http-equiv="Refresh" content="2;url=frontIndex.html">
<?php
} 
else
{
    die( print_r( sqlsrv_errors(), true ));
    echo "Failed to register.Please Try again later";
}
   /*
    $conn->exec();
    
    $sql="INSERT INTO dbo.Table(name,Email,Password,Address,Mobile,city,state) VALUES('$name','$mail','$pass','$address','$phone','$city','$state')";
    $conn->exec();
    $sql="COMMIT TRANSACTION";
    $conn->exec();
   */
    // $conn = mysqli_connect($host,$dbuser,$dbpass,$dbname);
    // if (!$conn){
    //     die('error connecting to database');
    // }else{
    //     mysql_select_db(dbname, $conn);
    // }

}

if($flag==1)
{

/*$res=($conn,$sql);
if(!$res)
{
  die("Failed to register.Try Again Later...");
}
else
{
	echo "<p>Registered Succesfully..</p>";
}
}*/

}
 ?>

</body>
</html>
<?php
if($flag==1)
$conn=NULL;

 ?>