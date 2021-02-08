<html>
<head>
<title>
    Pending/Confirmed Requests - BLISS
</title>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1">  -->
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange|Bevan" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Aldrich" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="description" content="Here registered NGOs can accept/reject their pending requests and also can view their confirmed requests' details.">
<style>
html{
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
body{
    margin:0;
    width:100%;
    height:100%;
}
.header{
    width:100%;
    margin:0;
    padding:0;
    text-align:center;
    background-color:#34495e;
    color:white;
    height:50px;
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:center;
    font-family:'Righteous';
}
.container1{
    height:200px;
    width:100%;
    position:relative;
    top:0;
    background-color:#c7ecee;
    padding-left:0;
}
.container2{
    height:200px;
    width:100%;
    position:relative;
    top:0;
    background-color:#95afc0;
    padding:0;
}
.name{
    font-family:'Righteous',cursive;
    text-transform:uppercase;
    font-size:25px;
    color:#2d3436;
}
.status1{
    color:#c0392b;
    font-family:Aldrich;
    font-weight:bolder;
    font-size:20px;
}
.status2{
    color:#27ae60;
    font-family:Aldrich;
    font-weight:bolder;
    font-size:20px;
}
.link1{
    font-family:'Maiden Orange';
    text-transform:uppercase;
    text-decoration:none;
    color:black;
}
.link2{
    font-family:'Maiden Orange';
    text-transform:uppercase;
    text-decoration:none;
    color:black;
}
.message{
    font-family:'Righteous';
    
}
.cover{
    position:fixed;
    width:100%;
    height:100%;
    background-color:rgba(0,0,0,0.9);
    top:0;
    left:0;
    z-index:50;

}
.cover2{
    position:fixed;
    width:100%;
    height:100%;
    background-color:rgba(0,0,0,0.9);
    top:0;
    left:0;
    z-index:50;

}
.box{
    position:absolute;
    height:50%;
    width:50%;
    top:25%;
    left:25%;
    background-color:white;
    line-height:150%;
    padding:5px;
    z-index:50;
}
.th{
    font-family:'Maiden Orange',cursive;
    text-transform:uppercase;
    font-size:20px;
    
}
.info{
    font-family:'Righteous',cursive;
    color:#2c3e50;
    font-size:20px;
}
iframe{
    position:fixed;
    top:10%;
    left:20%;
    width:60%;
    height:80%;
    z-index:100;
    overflow:hidden;
}
#logout-button{
    position: absolute;
    top: 1.5%;
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
 /* @media only screen and (max-width: 600px){
    iframe{
    position:fixed;
    top:10%;
    left:20%;
    width:90%;
    height:1200px;
    z-index:100;
    overflow:hidden;
}  */
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
<a href="https://bliss19.azurewebsites.net/frontIndex.html" style="text-decoration:none;"><input type="button" id="logout-button" value="LOG OUT"></a>
<?php
session_start();
?>
<?php
$ngomail="";
$mail=md5($_SESSION['login-mailngo']);
$code=$_SESSION['login-code'];
if($mail==$code){
    $ngomail=$_SESSION['login-mailngo'];
}
if($ngomail==""){
    ob_start();
    header("Location: login.php");
    ob_end_flush();
    die();
}
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true );
        echo "<p>Failed to connect to server..</p>";
   }
   else{
       //echo "connected";
   }
   $sql="SELECT * FROM records WHERE Email='$ngomail'";
   $res=sqlsrv_query($conn,$sql);
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
       $ngoname=$row['name'];
       $ngoaddress=$row['Address'];
       $ngophone=$row['Mobile'];
   }
sqlsrv_commit($conn);
    $sql="SELECT * FROM all_user_records WHERE ngomail='$ngomail'";
    $param=array($user_name,$user_mail,$date,$time,$user_phone,$useraddress,$ngoname,$ngoemail,1,0,$user_city);
   $res = sqlsrv_query( $conn, $sql);
   $flag=0;
   $count=0;
   echo "<h3 class='header'>PENDING REQUESTS</h3>";
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
        $str="";
       $pending=$row['pending'];
       settype($pending,'int');
       if($pending==1){
        //    $str.="NAME:".$row['name']."<br>";
        //    $str.="EMAIL:".$row['Email']."<br>";
        //    $str.="ADDRESS:".$row['address']."<br>";
        //    $str.="PHONE:".$row['phone']."<br>";
        $count++;
        $user_name=$row['name'];
        $user_address=$row['address'];
        $user_mail=$row['Email'];
        $user_phone=$row['phone'];
        $distance_taken=$row['distance_taken'];
        $time_taken=$row['time_taken'];
        $date=$row['date'];
        $time=$row['time'];
        $user_city=$row['city'];
        $flag=1;
        if($count%2==1){
            $class='container1';
        }
        else{
            $class='container2';
        }
        echo "<div class='$class'><div class='name'>$user_name</div><br><div class='status1'>Status:Pending</div><br>";
        echo $str."<br><a class='link1' target='if".$count."' href='http://bliss19.azurewebsites.net/confirm_ngo_portal.php?address=$user_address&name=$user_name&mail=$user_mail&user_city=$user_city&phone=$user_phone&date=$date&time=$time&distancetaken=$distance_taken&timetaken=$time_taken&ngoname=$ngoname&ngomail=$ngomail&ngophone=$ngophone&ngoaddress=$ngoaddress'><u><i>Click to go to Confirmation Page</i></u></a>";
        echo "</div>";
        echo "<div class='cover2'><iframe name='if".$count."'></iframe></div>";
    }
       
   }
   if($flag==0){
       echo "<div class='message'>NO PENDING REQUEST FOUND</div>";
   }
   if($res) {
    sqlsrv_commit($conn);
    //echo "<p>Registered successfully..</p>";
   }
   $flag=0;
    echo "<h3 class='header'>CONFIRMED REQUESTS</h3>";
    $sql="SELECT * FROM all_user_records WHERE ngomail='$ngomail' AND pending=0 AND result=1";
    $param=array($user_name,$user_mail,$date,$time,$user_phone,$useraddress,$ngoname,$ngoemail,1,0,$user_city);
    $res=sqlsrv_query($conn,$sql);
    
    while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
        $count++;
        $user_name=$row['name'];
        $user_address=$row['address'];
        $user_mail=$row['Email'];
        $user_phone=$row['phone'];
        $distance_taken=$row['distance_taken'];
        $time_taken=$row['time_taken'];
        $date=$row['date'];
        $time=$row['time'];
        $user_city=$row['city'];
        $flag=1;
        if($count%2==1){
            $class='container1';
        }
        else{
            $class='container2';
        }
        echo "<div class='$class'>";
        echo "<div class='name'>$user_name</div><br>";
        echo "<div class='status2'>Status:Confirmed</div><br>";
        echo "<a href='' class='link2'><u><i>CLICK TO SEE INFORMATION</i></u></a><br>";
        echo "</div>";
        echo "<div class='cover'><div class='box'>";
        echo "<span class='th'>Name</span>:<span class='info'>$user_name</span><br>";
        echo "<span class='th'>Mail</span>:<span class='info'>$user_mail</span><br>";
        echo "<span class='th'>Phone</span>:<span class='info'>$user_phone</span><br>";
        echo "<span class='th'>Address</span>:<span class='info'>$user_address</span><br>";
        echo "<span class='th'>Date</span>:<span class='info'>$date</span><br>";
        echo "<span class='th'>Time</span>:<span class='info'>$time</span><br>";
        echo "<span class='th'>Distance</span>:<span class='info'>$distance_taken</span><br>";
        echo "<span class='th'>Time to reach</span>:<span class='info'>$time_taken</span><br>";
        echo "</div></div>";
        
    }
    if($flag==0){
        echo "<div class='message'>NO CONFIRMED REQUESTS FOUND</div>";
    }

   ?>
</body>
<script>

    $('.cover').hide();
    $('.cover2').hide();
    $('.link2').click(function(event){
        event.preventDefault();
        $(this).parent().next().slideDown('slow');
        $('.cover').click(function(event2){
            if((!$(this).hasClass("link2"))&&(!$(event2.target).hasClass("box")))
            $('.cover').slideUp();
           
        });

    });
    
    $(".link1").click(function(){        //alert('hello');
        var clicked=$(this).parent().next();
        clicked.slideDown('slow');
        clicked.click(function(event2){
            if((!$(this).hasClass("link1"))&&(!$(event2.target).is("iframe")))
            clicked.slideUp();
            // document.location.reload(true);
        });
    });

</script>
</html>
