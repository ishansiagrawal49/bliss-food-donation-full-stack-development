<?php
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        echo "<p>Failed to connect to server..</p>";
   }
   $sql="SELECT COUNT(*) AS count,rating FROM record_rating GROUP BY rating";
   $res=sqlsrv_query($conn,$sql);
   $count=['0','0','0','0','0'];
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
       $index=$row['rating'];
       
       settype($index,'int');
    //    echo $index."<br>";
    //    echo $row['count']."<br>";
       $count[$index-1]=$row['count'];
   }
   $sql="SELECT ROUND(AVG(CAST(rating AS FLOAT)),1) AS average FROM record_rating";
   $res=sqlsrv_query($conn,$sql);
   $avg=0;
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
       $avg=$row['average'];
   }
   $sum=0;
   $percentage=[];
   for($i=0;$i<5;$i++){
       $num=$count[$i];
       settype($num,'int');
       $sum+=$num;
   }
   for($i=0;$i<5;$i++){
       $percentage[$i]=$count[$i]/$sum*100;
       $percentage[$i].="%";
   }
   sqlsrv_commit($conn);
   $conn=NULL;
 
?>

<div class="body">

<span class="heading">User Rating</span>
<span class="stars">
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
</span>
<p><?php echo $avg?> average based on <?php echo $sum;?> reviews.</p>
<hr style="border:3px solid #f1f1f1">

<div class="row">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $count[4];?></div>
  </div>
</div>
  <div class="row">
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $count[3];?></div>
  </div>
</div>
<div class="row">
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $count[2];?></div>
  </div>
</div>
<div class="row">  
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $count[1];?></div>
  </div>
</div>
<div class="row">  
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $count[0];?></div>
  </div>
</div>
</div>

<script>

var width="<?php echo $percentage[4]?>";
$(".bar-5").css({"width":width});

width="<?php echo $percentage[3]?>";
$(".bar-4").css({"width":width});

width="<?php echo $percentage[2]?>";
$(".bar-3").css({"width":width});

width="<?php echo $percentage[1]?>";
$(".bar-2").css({"width":width});

width="<?php echo $percentage[0]?>";
$(".bar-1").css({"width":width});

var num=parseFloat("<?php echo $avg?>");
num=Math.floor(num);
// document.write(num);
for(var i=1;i<=5;i++){
    var selector=".stars > span";
    if(i<=num)
    $(selector).eq(i-1).addClass("checked");
    else
    $(selector).eq(i-1).removeClass("checked");
}
</script>
