<?php
$name=$_POST['name'];
$rating=$_POST['rating'];
$review=$_POST['review'];
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

   $sql="INSERT INTO record_rating (name,rating,review) VALUES(?,?,?)";
   $param=array($name,$rating,$review);
   $res = sqlsrv_query( $conn, $sql,$param);
   if($res) {
    sqlsrv_commit($conn);
    echo "<p>Submitted successfully..</p>";
    $conn=NULL;
   }
?>