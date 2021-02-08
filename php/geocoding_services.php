<?php
header("Access-Control-Allow-Origin:*");
$origin=$_GET["origin"];

$destination=$_GET["destination"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Geocoding services - BLISS</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Locating addresses on map">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        width:100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
         center:{lat: -34.397, lng: 150.644}
        });
        var img="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        var geocoder = new google.maps.Geocoder();
        var address1 = "<?php echo $origin;?>";
        var obj;
        geocoder.geocode({'address': address1}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker1= new google.maps.Marker({
              
              map:map,
              label:{
                  color:"maroon",
                  fontWeight:"bold",
                  text:"YOUR LOCATION",
              },
              //icon:img,
              position: results[0].geometry.location
            });
           
          }
            });
    var address="<?php echo $destination;?>";
    var img="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"
   //var img="http://labs.google.com/ridefinder/images/mm_20_blue.png"  
   var string=address.substring(0,address.indexOf(','));
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            var marker = new google.maps.Marker({
              //icon:img,
              map:map,
              label:{
                  text:" "+string.toUpperCase(),
                  color:"maroon",
                  fontWeight:"bold",
              },
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });

  
}   

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0WxLMoI0Pzj7u4IxbKBBUdZtzrDW2Q4M&callback=initMap">
    </script>
  </body>
</html> 