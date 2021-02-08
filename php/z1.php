<?php
header("Access-Control-Allow-Origin:*");
$address=$_POST["address"];
$city=$_POST["city"];
$state=$_POST["state"];

$conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
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
    
    $rating=$row['rating'];
    if($rating==''){
        $rating='0';
    }
    array_push($arr_rating,$rating);
    $review_count=$row['no_of_reviews_recieved'];
    if($review_count==""){
        $review_count="0";
    }
    // echo $row['name']." $review_count<br>";
    array_push($arr_count,$review_count);
    //array_push($arr_name,$row["name"]);
}
$list='["' . implode('";"', $arr) . '"]';
$list2='[' . implode(';', $arr_name) . ']';
$list3='[' . implode(';', $arr_email) . ']';
$list4='[' . implode(';', $arr_phone) . ']';
$list5='[' . implode(';', $arr_rating) . ']';
$list6='[' . implode(';', $arr_count) . ']';
// $url = 'http://bliss19.azurewebsites.net/z9.php';
// $ch = curl_init($url);
$data = array(
    'list'=>$list,
    'list2'=>$list2,
    'list3'=>$list3,
    'list4'=>$list4,
    'list5'=>$list5,
    'list6'=>$list6
);
$payload = json_encode(array("user" => $data));
echo $payload;
// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $result = curl_exec($ch);
// curl_close($ch);
?>
