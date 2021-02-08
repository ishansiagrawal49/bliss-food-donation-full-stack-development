<?php
$ngoname=$_GET['name'];
if($ngoname==""){
    ?>
    <meta http-equiv="Refresh" content="1;url=frontIndex.html">
    <?php
}
if($_SERVER['REQUEST_METHOD']=="POST"){
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
                 $message="Thanks for your feedback..";
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
                $conn=NULL;
            }
        }
   }
?>
<meta http-equiv="Refresh" content="1;url=frontIndex.html">
   <?
}
?>
<html>
<head>
<title> NGO Feedback - BLISS </title>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="description" content="Here you can leave valuable feedback regarding the NGO you have donated to.">
<link href='https://fonts.googleapis.com/css?family=Laila' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Merriweather Sans' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Mogra' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Oleo Script' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Alfa Slab One' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Coustard' rel='stylesheet'>
<script>
    function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function sl(){
}
</script>
<script>
    $(function(){
        rating = -1;
        $("[name='star']").click(function(event){
                    var string=event.target.id;
                    rating=string[4];
                    var i=0;
                    for(i=0;i<rating;i++){
                        $("[name='star']").eq(i).addClass("checked");
                        $("[name='star']").eq(i).removeClass("checked2");
                    }
                    for(i=rating;i<5;i++)
                    {
                        $("[name='star']").eq(i).removeClass("checked");
                    }
                    $("[name='rating']").val(rating);
                });
                $("[name='star']").hover(function(event){
                    var string=event.target.id;
                    rating1=string[4];
                    var i=0;
                    for(i=0;i<rating1;i++){
                        if(!$("[name='star']").eq(i).hasClass("checked")){
                        $("[name='star']").eq(i).addClass("checked2");
                        }
                        
                    }
                    for(i=rating1;i<5;i++)
                    {
                        $("[name='star']").eq(i).removeClass("checked2");
                    }
                },
            function(event){
                for(i=0;i<5;i++)
                    {
                        if(!$("[name='star']").eq(i).hasClass("checked"))
                        {
                        $("[name='star']").eq(i).removeClass("checked2");
                        }
                    }
            }
            );
                $("#btnSubmit").click(function(event){
                  
                    var ratingErr="";
                    var nameErr="";
                    if(rating==-1){
                        ratingErr="Please give a rating";
                        $("#ratingErr").html(ratingErr);
                        event.preventDefault();
                    }
                    else{
                        $("#ratingErr").html("");
                    }
    });
    });
</script>

<style>
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
  .fa-star{
    color:lightgrey;
}
.checked {
    color:orange;
}
.checked2{
    color:orange;
}
html{
    height:100%;
}
body{
    height: 100%;
    margin:0;
    padding: 0;
}
form{
    position: absolute;
    width: 40%;
    height: 540px;
    left:30%;
    top:10%;
    border-radius: 15px;
    opacity: 1;
}
.backimg{
    width:100%;
    height:100%;
}
.head{
    width:100%;
    height:20%;
    text-weight: bold;
    background-color: rgb(255, 51, 0);
    font-size: 50px;
    font-family: Righteous;
    position: absolute;
    top:0%;
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:center;
    border-radius: 15px 15px 0px 0px;
}
.body{
    position: absolute;
    top:20%;
    background-color: white;
    width:100%;
    height:80%;
    border-radius: 0px 0px 15px 15px;
}
.td{
    font-size: 24px;
    font-family:Coustard;
}
.td1{
    font-size: 25px;
    font-family: Mogra;
}
#btnSubmit{
    height: 45px;
    width:150px;
    font-size: 25px;
    font-family: verdana;
    text-transform: capitalize;
    background-color: blue;
    color: white;
    border-radius: 8px;
}
.err{
    color: red;
    font-family: comic sans ms;
}
#para{
    font-weight: bold;
    font-family: Algerian;
    font-size: 20px;
}
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
<img src="http://walldiskpaper.com/wp-content/uploads/2014/11/Green-Brown-Wallpaper-Art.jpeg" class="backimg" alt="background_image">
<center>
<form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" name="feedback" >
    <div class="head">
        <p class="upar">FEEDBACK</p>
    </div>
<div class "image_cont">
<div class="cont-cont">
</div>
<img src="loading1.gif" class="image_load">
</div>
<div id="show_review">
        
</div>
                
<br>
<br>
<br>
<div class="body">
<br>
<span class="td" align="center">Dear user, please provide your feedback<br> for <?php echo $ngoname ;?> to help us get better.</span><span class="err" id="nameErr"></span><br><br>
<br><input type="hidden" placeholder="Enter your Name" name="name" value="<?php echo $ngoname?>" id="txtName" readonly><br> 
<br><br><span class="td1">Ratings:</span><br>
<span class="fa fa-star fa-2x" name="star" id="star1"></span>
<span class="fa fa-star fa-2x" name="star" id="star2"></span>
<span class="fa fa-star fa-2x" name="star" id="star3"></span>
<span class="fa fa-star fa-2x" name="star" id="star4"></span>
<span class="fa fa-star fa-2x" name="star" id="star5"></span><br>
<span class="err" id="ratingErr"></span><br>
<input type="hidden" name="rating"><br><br><br>
<input type="submit" name="submit" value="SUBMIT" id="btnSubmit">
<p id="para"><?php echo $message?></p>
</div>
</form>
</center>
</body>
</html>
