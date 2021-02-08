<?php
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        //echo "hi<br>";
        echo "<p>Failed to connect to server..</p>";
   }
   $start=$_POST['start'];
   settype($start,"int");
   $sql="SELECT MAX(id) AS count FROM record_rating";
   $res=sqlsrv_query($conn,$sql);
   $max=0;
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
       $max=$row['count'];
   }
   settype($max,"int");
   $limit=$max-$start;
   $sql="SELECT TOP 5 * FROM record_rating  WHERE id<=".$limit." ORDER BY id DESC";
   $res = sqlsrv_query( $conn, $sql);
   $count=0;
   echo "<div class='contain_all'>";
   while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){
    $name=$row['name'];
    $rating=$row['rating'];
    $review=$row['review'];  
    echo "<div class='contain_review'>";
    echo "<span class='name'>".ucfirst($name)."</span><span class='getStars' id='$rating'></span><br><br><i class='fa fa-quote-left'></i><br><br><span class='content_review'>$review</span><br><br>&nbsp&nbsp&nbsp&nbsp<i class='fa fa-quote-right'></i><br>";
    echo "</div>";
    $count++;
   }
   echo "</div>";
   echo "count=$count";
   sqlsrv_commit($conn);
   $conn=NULL;
 
?>