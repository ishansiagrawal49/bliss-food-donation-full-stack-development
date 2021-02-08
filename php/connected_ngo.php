<html>
    <head>
       <title>NGOs connected with BLISS</title>
       <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
    <link href="connected_ngo.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn|Righteous|Aldrich|Maiden+Orange" rel="stylesheet"> 
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="connected_ngo.js" type="text/javascript"></script>
    <link href='tiltedpage-scroll.css' ref='stylesheet' type='text/css'>
    <script src='jquery.tiltedpage-scroll.js' type='text/javascript'></script>
    <meta name="description" content="Here you can look at all the organisations registered with BLISS.">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!--     
    <script src="https://www.google.com/uds/api?file=uds.js&v=1.0&key=AIzaSyBYV11TK2I0IHYWHUw4FabOS5stTmB-bL4" type="text/javascript"></script>
  
    <script language="Javascript" type="text/javascript"> //<![CDATA[ // Create a search control 
    var searchControl = new GSearchControl(); // create a search object 
    var siteSearch = new GwebSearch(); 
    siteSearch.setUserDefinedLabel("bliss19.azurewebsites.net"); 
    siteSearch.setUserDefinedClassSuffix("siteSearch"); 
    siteSearch.setSiteRestriction("http://bliss19.azurewebsites.net/form_web.php"); 
    searchControl.addSearcher(siteSearch); // tell Google where to draw the searchbox 
    searchControl.draw(document.getElementById("search-box")); } 
    GSearch.setOnLoadCallback(OnLoad); //]]> </script> -->
<script>
  $(function(){
  
    $(window).load(function(){  
  $(".image_cont,.image_load,.cont-cont").hide();
});


});

</script> 
<script>
$(function(){
      $(".main").tiltedpage_scroll({
    sectionContainer: "> section",     // In case you don't want to use <section> tag, you can define your won CSS selector here
    angle:50,                         // You can define the angle of the tilted section here. Change this to false if you want to disable the tilted effect. The default value is 50 degrees.
    opacity: true,                     // You can toggle the opacity effect with this option. The default value is true
    scale: true,                       // You can toggle the scaling effect here as well. The default value is true.
    outAnimation: true                 // In case you do not want the out animation, you can toggle this to false. The defaul value is true.
  });

});
</script> 
<script>
   
function printStars(){
    var starSpan=$(".getStars");
 
    starSpan.each(function(){
                         var numb=parseInt($(this).html());
                         
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
                   
</script>
</head>
<body> 
<div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
    <div class="image_container">
    <!-- <img class="bcg" src="img_(web)_a.jpg"> -->
    </div>
    <div class="container1">
    
    <div class="info1">
    <h2 class="top_header">O u r&nbsp&nbsp&nbsp&nbsp&nbspF a m i l y</h2>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p>
        Here you can find a list of Orgnisations registered with BLISS
    </p>
    </div>
    </div>
    <br><br>
    <div id="search-box" style="height:50px;"> </div>
    
    <?php
         $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
        $serverName = "tcp:_.database.windows.net,1433";
        $conn = sqlsrv_connect($serverName, $connectionInfo);
        if ( sqlsrv_begin_transaction( $conn ) === false ) {
         //die( print_r( sqlsrv_errors(), true ));
         echo "<p>Failed to connect to server..</p>";
         }
 
    $sql="SELECT * FROM records ORDER BY city ASC";
    $param=array($name,$mail,$pass,$address,$phone,$city,$state);
    $res = sqlsrv_query( $conn, $sql);
    if($res) {  
    $count=0;
    $oldcity="";
    $city="";
    $str="";
    echo "<div class='main'>";
    while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC))
    {
        $count++;
        $str= "<section class='page".$count."'><div class='container_new'><h4 class='header_new'>";
        foreach($row as $key=>$val)
        {
            
            if($key=="Password")continue;
            if($key=="Mobile")
            {
                
                $store=$val;
                continue;
            }
            if($key=='name')
            {
                $str.= ucfirst($val).'<h4><p class="info_new">';
                continue;
            }  
            if($key=='city')
            {
                $val=strtolower($val);
                $city=$val;
            }
            if($key=='rating'){
                if($val==""){$val='0';}
                $str.="<span class='getStars'>$val</span><br>";
            }  
            else{
            $str.='<b>'.ucfirst($key)."</b>:$val<br>";
            }
        }
        $str.= "<b>Phone</b>:$store</p></div></section></center><br><br><br><br><br>";
        if($city!=$oldcity)
        {
            $str="<h3 align='center' class='city_header'>".strtoupper($city)."</h3>".$str;
            $oldcity=$city;
        }
        echo $str;
    }
    echo "</div>";
    sqlsrv_commit($conn);
}
    ?>
  <script>
      printStars();
  </script>
</body>
</html>