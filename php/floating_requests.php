<?php
session_start();
?>
<?php
// $address=$_POST["address"];
// $city=$_POST["city"];
// $state=$_POST["state"];
$mailngo="";
$mail=md5($_SESSION['login-mailngo']);
$code=$_SESSION['login-code'];
if($mail==$code){
    $mailngo=$_SESSION['login-mailngo'];
}
if($mailngo==""){
    ob_start();
    header("Location: login.php");
    ob_end_flush();
    die();
}
// $address="Lucknow,Uttar Pradesh,India";
// $city="Lucknow";
// $state="Uttar Pradesh";

$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ( sqlsrv_begin_transaction( $conn ) === false ) {
echo "<p>Failed to connect to server..</p>";
}
$sql="SELECT * FROM records WHERE Email='$mailngo'";
$res=sqlsrv_query($conn,$sql);
while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
    $address=$row['Address'];
    $city=$row['city'];
    $state=$row['state'];
    $namengo=$row['name'];
    $phonengo=$row['Mobile'];
}





/////////////////////////////////////////////////////////////////////////////////////////////
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ( sqlsrv_begin_transaction( $conn ) === false ) {
//die( print_r( sqlsrv_errors(), true ));
echo "<p>Failed to connect to server..</p>";
}
$sql="SELECT * FROM user_records WHERE city='$city'";
$res = sqlsrv_query( $conn, $sql);
$arr=[];
$arr_name=[];
$arr_phone=[];
$arr_email=[];
$arr_date=[];
$arr_time=[];
$counter=0;
while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC))
{
  //  print_r($row);
    /*foreach($row as $key=>$val)
    {
        if($key=="Address")
        {
            array_push($arr,$val);
        }
    }*/
    array_push($arr,$row["address"]);
    array_push($arr_email,$row["Email"]);
    array_push($arr_phone,$row["phone"]);
    array_push($arr_name,$row["name"]);
    array_push($arr_date,$row['date']);
    array_push($arr_time,$row['time']);
    $counter++;
    //array_push($arr_name,$row["name"]);
}
$list='["' . implode('","', $arr) . '"]';
$list2='["' . implode('","', $arr_name) . '"]';
$list3='["' . implode('","', $arr_email) . '"]';
$list4='["' . implode('","', $arr_phone) . '"]';
$list5='["' . implode('","', $arr_date) . '"]';
$list6='["' . implode('","', $arr_time) . '"]';
if($counter==0){
    $message='No pending requests found at this time';
}
else{
    $message="";
}
?>

<html>
<head>
<title> Floating Donation Requests - BLISS </title>
<meta name="description" content="Here any NGO can handle the floating doantion requests.">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="floating_requests.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald|Spirax" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Vollkorn" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'> 
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script><script  defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyB0WxLMoI0Pzj7u4IxbKBBUdZtzrDW2Q4M"  type="text/javascript"></script>
<script>
$(function(){
$(document).scroll(function(){
var x=$(document).scrollTop();
var y=Math.floor(x/1000);
if(y%2==0){
    // $('.bcg').css({
    //     "content":"url('http://backgroundcheckall.com/wp-content/uploads/2017/12/blur-background-photography-hd-3.jpg')"
    // });
    // $(".bcg").attr("src",'img_2(php)_1.jpeg');
}
else{
    // $('.bcg').css({
    //     "content":"url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTokkaGIOsGxiF9TfGozs9UCyYmk3Urfz6b4mH9Vc2PmSHWaScu')"
    // // });
    // $(".bcg").attr("src","img_2(php)_2.png");
}
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
<style>
    #logout-button{
    z-index: 60;
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
</style>
</head>
<body>
<a href="https://bliss19.azurewebsites.net/frontIndex.html" style="text-decoration:none;"><input type="button" id="logout-button" value="LOG OUT"></a>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
    <!-- <div class="image_container">
    <img class="bcg" src="">
    </div> -->
    <h2 class="header">Users Near You</h2>
<p class='para'>
    Following is a list of users who are willing to donate food.These have been sorted according to the distance from your organisation's location
    You can see their loation by clicking on 'Click to See Location' link.To confirm the request ,please select the option 'Confirm Request'.
    You will receive a mail regarding the information of the person once this is done.
</p>
<div class='message'><?php echo $message;?></div>
    <p id = "result"></p>
</body>
<script>

        // calculate distance
        $(function(){
            function sendmail(){
                $(".link_date").click(
                    function(){
                        
                        var string=$(this).attr('name');
                        $.get(string,function(data){
                            alert(data);
                            document.location.reload(true);
                        });
                    }
                );
            }
            
            function fun(){
           $(".link,iframe").hide();
             return true;
               }
            flag=0;
        function calculateDistance() {
            var origin = "<?php echo $address;?>";
            var destination = <?php echo $list;?>;
            name2=<?php echo $list2;?>;
            mail=<?php echo $list3;?>;
            phone=<?php echo $list4;?>;
            set_date=<?php echo $list5;?>;
            set_time=<?php echo $list6;?>;
            phonengo="<?php echo $phonengo?>";
            mailngo="<?php echo $mailngo?>";
            namengo="<?php echo $namengo?>";
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins: [origin],
                    destinations: destination,
                    travelMode: google.maps.TravelMode.DRIVING,
                    //unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
                     unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
                    avoidHighways: false,
                    avoidTolls: false
                }, callback);
        }
        // get distance results
        var dist=[];
        var para=[];
        var size=0,c=0;
        function callback(response, status) {
            if (status != google.maps.DistanceMatrixStatus.OK) {
                $('#result').html(err);
            } else {
                var str="";
                    var i=0;
                    for(i=0;i<response.rows[0].elements.length;i++)
                    {
            
               
                var origin = response.originAddresses[0];
                var destination = response.destinationAddresses[i];
                var origin="<?php echo $address?>";
                if (response.rows[0].elements[i].status === "ZERO_RESULTS") {

                  
                } else{
                    
                    size++;
                    str="<div class='container'><iframe name='if"+size+"'></iframe><div class='container_new'>";
                    var distance = response.rows[0].elements[i].distance;
                    var duration = response.rows[0].elements[i].duration;
                    var distance_in_kilo = distance.value / 1000; // the kilo
                   /* var distance_in_mile = distance.value / 1609.34; // the mile
                    var duration_text = duration.text;
                    var duration_value = duration.value;
                    $('#in_mile').text(distance_in_mile.toFixed(2));
                    $('#in_kilo').text(distance_in_kilo.toFixed(2));
                    $('#duration_text').text(duration_text);
                    $('#duration_value').text(duration_value);
                    $('#from').text(origin);
                    $('#to').text(destination);*/
                    //$("#result").html(response.rows.length+" "+response.rows[0].elements.length+" "+distance_in_kilo+" "+duration.value/60);
                    // str+="<span class='header_new'>"+name2[i].toUpperCase()+"</span>";
                    str+="<p class='info_new'><span class='header_new'>"+name2[i].toUpperCase()+"</span><b><span class='th'>Distance</span></b>:"+distance_in_kilo.toFixed(0)+" km<br>"
                    str+="<b><span class='th'>Duration</span></b>:"+(duration.value/60).toFixed(0)+" minutes<br>";
                    var distance_send=distance_in_kilo.toFixed(0)+" km";
                    var time_send=(duration.value/60).toFixed(0)+" minutes"
                    var city_user="<?php echo $city?>";
                    var query="origin="+origin+"&destination="+destination;
                    str=str+"<a class='link' target='if"+size+"' href='http://bliss19.azurewebsites.net/geocoding_services.php?"+query+"'>Click</a><br>";
                    
                    str+="<b><span class='th'>Address</span></b>:"+destination+"<br>";
                    str+="<b><span class='th'>Email</span></b>:"+mail[i]+"<br>";
                    str+="<b><span class='th'>Phone</span></b>:"+phone[i]+"<br>";
                    str+="<b><span class='th'>Date</span></b>:"+set_date[i]+"<br>";
                    str+="<b><span class='th'>Time</span></b>:"+set_time[i]+"<br>";
                    var query2="name="+name2[i]+"&mail="+mail[i]+"&phone="+phone[i]+"&origin="+origin+"&destination="+destination+"&namengo="+namengo+"&phonengo="+phonengo+"&mailngo="+mailngo+"&date="+set_date[i]+"&time="+set_time[i]+"&distance_taken="+distance_send+"&time_taken="+time_send;
             str+="<span class='link_date' name='confirm_floating_requests.php?"+query2+"'>Confirm Request</span><br>";
                    str+="<span id='hover"+size+"'>CLICK TO SEE LOCATION</span></p></div></div><br><br><br>";
                    dist.push(distance_in_kilo);
                    para.push(str);
                 
                }
                    
                }
                
                
                for(i=0;i<size-1;i++)
                {
                    small=dist[i];
                    small2=para[i];
                    pos=i;
                    for(j=i+1;j<size;j++)
                    {
                        if(dist[j]<small)
                        {
                            small=dist[j];
                            small2=para[j];
                            pos=j;
                        }
                    }
                    dist[pos]=dist[i];
                    dist[i]=small;
                    para[pos]=para[i];
                    para[i]=small2;
                }
                
                for(i=0;i<size;i++)
                {
                    var string=$("#result").html() + para[i];
                    $("#result").html(string);
                }
               
                for(i=0;i<size;i++)
                $(".link")[i].click();
                fun();
                // $("#hover").eq(0).hover(function(){
                //     $("iframe").show();
                // },
                // function(){
                //     $("iframe").hide();
                // }
            //);
            //alert($("#hover").parent().parent().prev().html());
                $("[id^=hover]").click(function(){
                        $(this).parent().parent().prev().fadeToggle('slow');
                });
                }
                sendmail();
            }
        calculateDistance()  ;
        
        });    
</script>
</html> 