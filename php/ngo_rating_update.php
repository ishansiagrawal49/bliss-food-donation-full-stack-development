<?php
// $name="bansal";
// $new_rating=3;
$name=$_POST['name'];
$new_rating=$_POST['rating'];
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        echo "<p>Failed to connect to server..</p>";
   }
   $sql1="SELECT * FROM ngo_rating WHERE name='$name'";
   $res1 = sqlsrv_query($conn,$sql1);
   if(sqlsrv_has_rows($res1)){
        $no=0;
        $avg=0;
        $f=0;
        while($row=sqlsrv_fetch_array($res1,SQLSRV_FETCH_ASSOC)){
            $no=$row['no_of_reviews_recieved'];
            $avg=$row['avg_rating'];
        }
        settype($no,int);
        settype($avg,float);
        settype($new_rating,int);
        $new_avg = ($avg*$no+$new_rating)/($no+1);
        $new_avg=round($new_avg,3);
        $no = $no + 1;
        $sql="UPDATE ngo_rating SET no_of_reviews_recieved='$no', avg_rating='$new_avg' WHERE name='$name'";
        $res = sqlsrv_query( $conn, $sql);
        if($res) {
            sqlsrv_commit($conn);
            $f=1;
            //echo "<p>Submitted successfully..</p>";
            //$conn=NULL;
        }
        settype($new_avg,int);
        //echo gettype($new_avg)."<br>".$new_avg."<br>";
        $sql2="UPDATE records SET rating='$new_avg' WHERE name='$name'";
        $res2 = sqlsrv_query($conn,$sql2);
        if($res2) {
            sqlsrv_commit($conn);
            if($f){
                echo "<p>Submitted successfully..</p>";
                $conn=NULL;
            }
        }
   }
   else{
       $f=0;
       $no=1;
       $sql="INSERT INTO ngo_rating (name,no_of_reviews_recieved,avg_rating) VALUES(?,?,?)";
        $param=array($name,$no,$new_rating);
        $res = sqlsrv_query( $conn, $sql,$param);
        if($res) {
            //sqlsrv_commit($conn);
            $f=1;
            //echo "<p>Submitted successfully..</p>";
            //$conn=NULL;
        }
        $sql2="UPDATE records SET rating='$new_rating' WHERE name='$name'";
        $res2 = sqlsrv_query($conn,$sql2);
        if($res2) {
            sqlsrv_commit($conn);
            if($f){
                echo "<p>Submitted successfully..</p>";
                $conn=NULL;
            }
        }
   }
   
?>