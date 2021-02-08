<?php
$address=$_POST["address"];
$city=$_POST["city"];
$state=$_POST["state"];
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ( sqlsrv_begin_transaction( $conn ) === false ) {
//die( print_r( sqlsrv_errors(), true ));
echo "<p>Failed to connect to server..</p>";
}
$sql="select records.*,ngo_rating.no_of_reviews_recieved from records left outer join ngo_rating on records.name=ngo_rating.name where records.city='$city'";
$res = sqlsrv_query( $conn, $sql);
$arr=[];
$arr_name=[];
$arr_phone=[];
$arr_email=[];
$arr_rating=[];
$arr_count=[];
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
    array_push($arr,$row["Address"]);
    array_push($arr_email,$row["Email"]);
    array_push($arr_phone,$row["Mobile"]);
    array_push($arr_name,$row["name"]);
    array_push($arr_rating,$row["rating"]);
    $review_count=$row['no_of_reviews_recieved'];
    if($review_count==""){
        $review_count="0";
    }
    // echo $row['name']." $review_count<br>";
    array_push($arr_count,$review_count);
    //array_push($arr_name,$row["name"]);
}
$list='["' . implode('","', $arr) . '"]';
$list2='["' . implode('","', $arr_name) . '"]';
$list3='["' . implode('","', $arr_email) . '"]';
$list4='["' . implode('","', $arr_phone) . '"]';
$list5='["' . implode('","', $arr_rating) . '"]';
$list6='["' . implode('","', $arr_count) . '"]';
?>

<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="ngo_nearby.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Vollkorn" rel="stylesheet"> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Maiden+Orange|Righteous|Aldrich" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script><script  defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyB0WxLMoI0Pzj7u4IxbKBBUdZtzrDW2Q4M"  type="text/javascript"></script>
<meta name="description" content="Here you will get a list of nearby NGOs near you">
<title>
    Nearby NGOs - Bliss
</title>
<script>
$(function(){
$(document).scroll(function(){
var x=$(document).scrollTop();
var y=Math.floor(x/1000);
if(y%2==1){
    // $('.bcg').css({
    //     "content":"url('http://backgroundcheckall.com/wp-content/uploads/2017/12/blur-background-photography-hd-3.jpg')"
    // });
    $(".bcg").attr("src",'img_2(php)_1.jpeg');
}
else{
    // $('.bcg').css({
    //     "content":"url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTokkaGIOsGxiF9TfGozs9UCyYmk3Urfz6b4mH9Vc2PmSHWaScu')"
    // });
    $(".bcg").attr("src","img_2(php)_2.png");
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
</head>
<body> 
<a href="http://bliss19.azurewebsites.net"><button style="position: absolute;top:0;left:0; z-index: 60; height:auto; width:auto;background-color:transparent;border:none;color:white;"><i class="fa fa-home fa-2x" aria-hidden="true";></i></button></a>
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
    <div class="image_container">
    <img class="bcg" src="img_2(php)_2.png" alt="background_image">
    </div>
    <h2 class="header">Organisations Near You</h2>

    <p id = "result"></p>
</body>
<script>

        // calculate distance
        $(function(){
            function printStars(){
                var starSpan=$(".getStars");
                starSpan.each(function(){
                         var numb=parseInt($(this).html());var starSpan=$(".getStars");
                            var stringer="";
                            for(var i=1;i<=5;i++){
                                if(i<=numb){
                                    stringer+="<span class='fa fa-star checked'></span>";
                                }
                                else{
                                    stringer+="<span class='fa fa-star'></span>";
                                }
                            }
                            stringer="<span class='rev'>"+stringer;
                            stringer+="</span>";
                            $(this).html(stringer);                            

                     
                 });

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
            rating=<?php echo $list5;?>;
            count_reviews=<?php echo $list6;?>;
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
                    str+="<h3 class='header_new'>"+name2[i].toUpperCase()+"</h3>";
                    str+="<p class='info_new'><b><span class='th'>Distance</span></b>:"+distance_in_kilo.toFixed(0)+" km<br>"
                    str+="<b><span class='th'>Duration</span></b>:"+(duration.value/60).toFixed(0)+" minutes<br>";
                    var distance_send=distance_in_kilo.toFixed(0)+" km";
                    var time_send=(duration.value/60).toFixed(0)+" minutes"
                    var city_user="<?php echo $city?>";
                    var query="origin="+origin+"&destination="+destination;
                    str=str+"<a class='link' target='if"+size+"' href='http://bliss19.azurewebsites.net/geocoding_services.php?"+query+"'>Click</a><br>";
                    
                    str+="<b><span class='th'>Address</span></b>:"+destination+"<br>";
                    str+="<b><span class='th'>Email</span></b>:"+mail[i]+"<br>";
                    str+="<b><span class='th'>Phone</span></b>:"+phone[i]+"<br>";
                    var query2="name="+name2[i]+"&mail="+mail[i]+"&phone="+phone[i]+"&origin="+origin+"&destination="+destination+"&distance_taken="+distance_send+"&time_taken="+time_send+"&city="+city_user;
                    str+="<br><span class='getStars'>"+rating[i]+"</span><span style='color:black;font-size:14px;'><i>(Based on "+count_reviews[i]+" reviews)</i></span><br>"
                    str+="<a class='link_date' href='http://bliss19.azurewebsites.net/date.php?"+query2+"'>Pick a Date and Time</a><br>";
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
                printStars();
            }
        calculateDistance()  ;
        
        });    
</script>
</html> 