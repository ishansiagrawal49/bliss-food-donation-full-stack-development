<?php
date_default_timezone_set("Asia/Kolkata");
$year=date("Y");
$month=date("F");
$day=date("j");
$date=date_create();
date_date_set($date,$year,$month,$day);
//date_add($date,date_interval_create_from_date_string("1 days"));
// echo date_format($date,"Y/m/d");
/////////////////////////////
$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
$connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:_.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        echo "<p>Failed to connect to server..</p>";
}
else{
    echo "connected";
}
   $sql="SELECT * FROM user_records";
   $res = sqlsrv_query( $conn, $sql);
/////////////////////////////
$email_delete=[];

while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){

    $mydate=$row['date'];
    $arr=explode(" ",$mydate);
   
    $myday=$arr[0];
    $mymonth=substr($arr[1],0,strlen($arr[1])-1);
    $myyear=$arr[2];
    //echo $myday."<br>";
    switch($mymonth){
        case 'January':$mymonth="01";break;
        case 'February':$mymonth="02";break;
        case 'March':$mymonth="03";break;
        case 'April':$mymonth="04";break;
        case 'May':$mymonth="05";break;
        case 'June':$mymonth="06";break;
        case 'July':$mymonth="07";break;
        case 'August':$mymonth="08";break;
        case 'September':$mymonth="09";break;
        case 'October':$mymonth="10";break;
        case 'November':$mymonth="11";break;
        case 'December':$mymonth="12";break;
    }
    // echo $mymonth;
    $mynewdate=date_create();
    //echo $myday."<br>";
    date_date_set($mynewdate,$myyear,$mymonth,$myday);
    echo date_format($mynewdate,"y/m/d")."<br>";
    $diff=date_diff($date,$mynewdate);
    $difference= $diff->format("%R%a");
    settype($difference,'int');
    echo $difference."<br>";
    if($difference<=0)
    {       
            $to=$row['Email'];
            array_push($email_delete,$to);
            

    }

}
sqlsrv_commit($conn);
$string="(";
for($i=0;$i<count($email_delete);$i++){
    $string=$string."'".$email_delete[$i]."'";
    if($i!=count($email_delete)-1){
        $string.=',';
    }
}    
print_r($email_delete);
$string.=')';
$sql="DELETE FROM user_records WHERE Email IN $string and date='$mydate'";
$res=sqlsrv_query($conn,$sql);
if($res) {
    sqlsrv_commit($conn);
    echo "deleted succesfully";
}

$sql="SELECT * FROM all_user_records";
$res = sqlsrv_query( $conn, $sql);
/////////////////////////////
$email_delete=[];

while($row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC)){

 $mydate=$row['date'];
 $arr=explode(" ",$mydate);

 $myday=$arr[0];
 $mymonth=substr($arr[1],0,strlen($arr[1])-1);
 $myyear=$arr[2];
 //echo $myday."<br>";
 switch($mymonth){
     case 'January':$mymonth="01";break;
     case 'February':$mymonth="02";break;
     case 'March':$mymonth="03";break;
     case 'April':$mymonth="04";break;
     case 'May':$mymonth="05";break;
     case 'June':$mymonth="06";break;
     case 'July':$mymonth="07";break;
     case 'August':$mymonth="08";break;
     case 'September':$mymonth="09";break;
     case 'October':$mymonth="10";break;
     case 'November':$mymonth="11";break;
     case 'December':$mymonth="12";break;
 }
 // echo $mymonth;
 $mynewdate=date_create();
 //echo $myday."<br>";
 date_date_set($mynewdate,$myyear,$mymonth,$myday);
 echo date_format($mynewdate,"y/m/d")."<br>";
 $diff=date_diff($date,$mynewdate);
 $difference= $diff->format("%R%a");
 settype($difference,'int');
 echo $difference."<br>";
 if($difference<=0)
 {       
         $to=$row['Email'];
         array_push($email_delete,$to);
         

 }

}
sqlsrv_commit($conn);
$string="(";
for($i=0;$i<count($email_delete);$i++){
 $string=$string."'".$email_delete[$i]."'";
 if($i!=count($email_delete)-1){
     $string.=',';
 }
}    
print_r($email_delete);
$string.=')';
$sql="DELETE FROM all_user_records WHERE Email IN $string and date='$mydate'";
$res=sqlsrv_query($conn,$sql);
if($res) {
 sqlsrv_commit($conn);
 echo "deleted succesfully";
}
?>