<?php
if(!isset($_POST["submit_form"]))
{
$ngo=$_GET["name"];
$email_ngo=$_GET["mail"];
$phone_ngo=$_GET["phone"];
$address_ngo=$_GET["destination"];
$address_user=$_GET["origin"];
$distance_taken=$_GET["distance_taken"];
$time_taken=$_GET["time_taken"];
$user_city=$_GET['city'];
//echo $ngo;
}
if(isset($_POST["submit_form"]))
{
$ngoname=$_POST["ngo"];
$ngoemail=$_POST["email_ngo"];
$phonengo=$_POST["phone_ngo"];
$ngoaddress=$_POST['address_ngo'];
$useraddress=$_POST['address_user'];
$user_city=$_POST['user_city'];
$url = 'https://api.sendgrid.com/';
$user = '_';
$pass = '_';
$to=$_POST["user_mail"];
$date=$_POST['date'];
$time=$_POST['time'];
$distance_taken2=$_POST['distance_taken'];
$time_taken2=$_POST['time_taken'];
//$$$$$$$$$$$$$$$$$$$$$$$$ SEND MAIL TO USER $$$$$$$$$$$$$$$$$$$$
// $message="succesfully initiated donation request to ".$ngoname.".You can contact them at E-mail ID:".$ngoemail." or phone number:".$phonengo."\nAddress:".$ngoaddress;
// $params = array(
//      'api_user' => $user,
//      'api_key' => $pass,
//      'to' => $to,
//      'subject' => 'Donation through Bliss18',
//      'html' => $message,
//      'text' => $message,
//      'from' => 'team@bliss18.azurewebsites.net'
//   );

// $request = $url.'api/mail.send.json';

// // Generate curl request
// $session = curl_init($request);

// // Tell curl to use HTTP POST
// curl_setopt ($session, CURLOPT_POST, true);

// // Tell curl that this is the body of the POST
// curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

// // Tell curl not to return headers, but do return the response
// curl_setopt($session, CURLOPT_HEADER, false);
// curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// // obtain response
// $response = curl_exec($session);
//curl_close($session);

// print everything out
//print_r($response);
//////////////////$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$//////////////////////////


$user_name=$_POST["user"];
$user_mail=$_POST["user_mail"];
$user_phone=$_POST["user_phone"];

/*Check date*/
$year=date("Y");
$month=date("F");
$todayday=date("j");
$todaydate=date_create();
date_date_set($date,$year,$month,$day);

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

// print everything out
//print_r($response);


//$$$$$$$$$$$$$$$$$$Inserting date and time$$$$$$$$$$$$$$$$$$$$$$$


$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
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
    ?>
    <!-- <meta http-equiv="Refresh" content="6;url=frontIndex.html"> -->
    <?php
   }
}


?>
<html>
<head>
    <title>
        Pick Donation Date And Time - Bliss</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
    <script src="picker.js" type="text/javascript"></script>
    <script src="picker.date.js" type="text/javascript"></script>
    <script src="picker.time.js" type="text/javascript"></script>
    <script src="legacy.js" type="text/javascript"></script>
    <link href="default.css" rel="stylesheet" type="text/css">
    <link href="default.date.css" rel="stylesheet" type="text/css">
    <link href="default.time.css" rel="stylesheet" type="text/css">
    <link href="style_date.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rakkas" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Vollkorn|Aldrich|Righteous|Maiden+Orange" rel="stylesheet"> 
<meta name="description" content="Here you can fix your desired date and time to make your donation request to the selected NGO.">


<script>
    $(function(){

        $("span").hide();
        if("<?php echo !isset($_POST["submit_form"])?>")
        {
        $(".message").hide();
        
        }
        else
        {
            $(".message").fadeIn('slow');
        }
        var flag=0;
        
        $("form").submit(function(event){
          
           
            for(var i=0;i<5;i++)
            {
                var val=$("[type='text']").eq(i).val();
                if(val==""||(i==4&&val.length()!=10)){
                    $('span').show();
                    event.preventDefault();
                    break;
                }
            }
    

        });
        $(".datepicker").click(function(){
        $(".datepicker").pickadate({
            min:new Date()
        });
        });
        $(".timepicker").click(function(){
        $(".timepicker").pickatime({
           
        });
        });
        
    });
</script>
<script>
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});


});

</script> 
</head>
<body> 
<a href="http://bliss19.azurewebsites.net"><button style="position: absolute; z-index: 60; height:auto; width:auto;background-color:transparent;border:none;color:white;"><i class="fa fa-home fa-2x" aria-hidden="true"></i></button></a>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
    <h3 class="header">Fix A Date and Time</h3>
    <div class="message">
    Your request has been taken into consideration.
    You will be notified if the organisation accepts your offer
    If the your request is rejected,it will be put up as a floating request
    where all other organisations can see it.Thanks for donating!
    </div>
    
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method=post>
    <span>All Fields are mandatory.Please fill them.</span><br><br>
        <input type="text" name="date" placeholder="Click to select a Date" class="datepicker"><br>
        <input type="text" name="time" placeholder="Click to select a Time" class="timepicker"><br>
        <input type="text" name="user" placeholder="Enter your Name"><br>
        <input type="text" name="user_mail" placeholder="Enter your E-mail ID"><br>
        <input type="text" name="user_phone" placeholder="Enter your Phone Number"><br>
          <br>
          <br>
          <input type="hidden" name="ngo" value="<?php echo $ngo;?>">
          <input type="hidden" name="email_ngo" value="<?php echo $email_ngo;?>">
          <input type="hidden" name="phone_ngo" value="<?php echo $phone_ngo;?>">
          <input type="hidden" name="address_ngo" value="<?php echo $address_ngo;?>">
          <input type="hidden" name="address_user" value="<?php echo $address_user;?>">
          <input type="hidden" name="distance_taken" value="<?php echo $distance_taken;?>">
          <input type="hidden" name="time_taken" value="<?php echo $time_taken;?>">
          <input type="hidden" name="user_city" value="<?php echo $user_city?>">
          <input type="submit" name="submit_form" value="SUBMIT">

          
    </form>
</body>    
</html>