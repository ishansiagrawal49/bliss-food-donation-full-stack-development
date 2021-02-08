<html>
    <head>
        <title>Feedback</title>
        <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Bevan" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Rakkas" rel="stylesheet">
        <?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
      }
    $email=$name=$rating=$comment="";
    $name_err=$email_err=$rating_err="";
    
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
    if (empty($_POST["user"])) {
        $email_err = "Email is required";
      }
      else {
        $email = test_input($_POST["user"]);
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $email_err = "Invalid email format"; 
         }

      }
    if (empty($_POST["name"])){
        $name_err = "Name required";
    }
    else {
        $name = test_input($_POST["name"]);
    }  
    if (empty($_POST["comment"])){
        $comment = "No comments found";
    }
    else {
        $comment = $_POST["comment"];
    }
    if (empty($_POST["tell"])){
        $rating_err = "field required";
    }
    else {
        $rating = test_input($_POST["tell"]);
    }
    }
    
    //
    $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "welcome@123");
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        echo "<p>Failed to connect to server..</p>";
   }?>
        <style>
            form{
			position:absolute;
            top=0;
			width:39%;
			left:25.5%;
			background-color: #EAEDED;
			opacity: 0.85;
			border:2px solid black;
            border-radius:7px;
            height:90%;
            z-index:10;
            color:#2874A6;
            }
        </style>   
    </head>
    <body style="background-color:#85C1E9">
        <center>
            <br>
            <form name="feedback" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div style="color:#2874A6">
                <h1 style="font-size:45px"><b>Feedback</b></h1>
                <h3><i>Your valuable Feedback can help us a lot to improve..</i></h3></div>
                <p id="p1" style="font-size:17px;font-family:"Courier New"">Your Name<br>*<span><?php echo $name_err;?></span><br><input type="text" name="name" placeholder="Enter your text here" value = "<?php echo $name;?>"></p>
                <p id="p2" style="font-size:17px;font-family:"Courier New"">Email<br>*<span><?php echo $email_err;?></span><br><input type="text" name="user" placeholder="Enter your text here" value="<?php echo $email;?>"></p>
                <p id="p3" style="font-size:17px;font-family:"Courier New"">How would you rate our services?<br>*<span><?php echo $rating_err?></span><br><input type="radio" name="tell" value="Very Poor" id="r1"><i>Very Poor</i><br><input type="radio" name="tell" value="Not much fascinating" id="r2"><i>Not much fascinating</i><br><input type="radio" name="tell" value="Helpful" id="r3"><i>Helpful</i><br><input type="radio" name="tell" value="Excellent" id="r4"><i>Excellent</i></p>
                <p id="p4" style="font-size:17px;font-family:"Courier New"">Comments(if any)<br><input type="text" name="comment" placeholder="Enter your text here" value="<?php echo $comment;?>" style="width:80%"></p><br>
                <input type="submit" id="s1" name="submit" value="Submit">
            </form>
        </center>
        <?php
            $flag=0;
            if($name_err==""&&$email_err==""&&$rating_err==""&&isset($_POST["submit"])){
             $flag=1;
             $sql="INSERT INTO our_feedback (name,email,rating,comments)  VALUES (?,?,?,?)";
             $param=array($name,$email,$rating,$comment);
             $res = sqlsrv_query( $conn, $sql,$param);
             if($res) {
              sqlsrv_commit($conn);
              echo "<p>Thnx for ur feedback..</p>";
              //sleep(5);
              //ob_start();
              //header("Location:https://bliss18.azurewebsites.net/newIndex.html");
              //ob_end_flush();
              //die();
             }
         
            }
            else
         {
             die( print_r( sqlsrv_errors(), true ));
             echo "Failed to register.Please Try again later";
         }
             
         
            if($_SERVER["REQUEST_METHOD"]=="POST"&&$flag==1){
                echo "hi";
                ?>
                <meta http-equiv="Refresh" content="2;url=.\frontIndex.html">
                <?php
            }
        ?>    
    </body>
</html>
