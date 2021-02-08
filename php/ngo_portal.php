<?php
session_start();
?>
<?php
    $mailngo="";
    $mail=md5($_SESSION['login-mailngo']);
    $code=$_SESSION['login-code'];
    if($mail==$code){
        $mailngo=$_SESSION['login-mailngo'];
    }
    if($mailngo==""){
        ob_start();
    header("Location: login.php");
    ob_end_flush();
    die();
    }
    $conn = new PDO("sqlsrv:server = tcp:_.database.windows.net,1433; Database = _", "_", "_");
   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $connectionInfo = array("UID" => "_@_", "pwd" => "_", "Database" => "_", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:_.database.windows.net,1433";
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        //die( print_r( sqlsrv_errors(), true ));
        echo "<p>Failed to connect to server..</p>";
    }
    $sql="SELECT name FROM records WHERE Email='$mailngo'";
    $data=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($data,SQLSRV_FETCH_ASSOC);
    $name=$row['name'];
    if($data){
        sqlsrv_commit($conn);
    }
?>
<html>
    <head>
            <link rel="icon" href="favicon.ico" type="image/x-icon">
            <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Kreon" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Maiden+Orange" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
            <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'> 
            <link href="https://fonts.googleapis.com/css?family=Aldrich" rel="stylesheet">
            <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https:/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="portal_style.css" rel="stylesheet" type="text/css">
        <meta name="description" content="Here registered NGOs can access their services provided by BLISS">
        <title>
            NGO services portal - BLISS    
        </title>    
        <script>
                $( function() {
              $( "#tabs" ).tabs();
              } );
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
    <div class "image_cont">
      <div class="cont-cont">
      </div>
    <img src="loading1.gif" class="image_load">
</div>
            
        <p id="welcome">Welcome <?php echo $name;?></p>
        <h2 class="header">SERVICES PORTAL</h2><a href="https://bliss19.azurewebsites.net/frontIndex.html" style="text-decoration:none;"><input type="button" id="logout-button" value="LOG OUT"></a>
        <div class="contain_para_image4">
             <!-- <img src="login.png" class="left_image2">  -->
        
            <div id="tabs">
                <ul>
                <li><a href="#tabs-1">PENDING/CONFIRMED REQUESTS</a></li>
                <li><a href="#tabs-2">FLOATING REQUESTS</a></li>
                <li><a href="#tabs-3">UPDATE INFORMATION</a></li>
                </ul>
            <div id="tabs-1">
              <p>Here you can accept/reject requests from the users who have chosen  your organisation as their first
                  preference.You can also see the confirmed requests and the contact details of the donor.
            </p>
                  <br>
                <br>
                    <br>
                    <br>
                    <br>
                    <a href="http://bliss19.azurewebsites.net/pending_requests.php" style="text-decoration:none;"><input type="button" id="tab-button" value="PROCEED"></a>
                
              
            </div>
            <div id="tabs-2">
                <p>Here you can see the the requests open to all N.G.Os and organisations
                    You can confirm any request as per your own convenience.Note that this is open 
                    to all and works on a first come first serve basis.
                </p>
                <br>
                    <br>
                    <br>
                    <br>
                <a href="http://bliss19.azurewebsites.net/floating_requests.php" style="text-decoration:none;"><input type="button" id="tab-button" value="PROCEED"></a>
                    
                
            </div>
            <div id="tabs-3">
                <p>
                    Here you can update the information of your N.G.O or organisation.
</p>    <br>
                    <br>
                    <br>
                    <br>
                    <?php $_SESSION['ngo-portal-flag']=1;?>
                    <a href="http://bliss19.azurewebsites.net/updateInfo.php" style="text-decoration:none;"><input type="button" id="tab-button" value="PROCEED"></a>


            </div>

        </div>

    </body>
</html>