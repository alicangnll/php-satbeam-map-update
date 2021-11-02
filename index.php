<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>SatBeams Datamap <?php echo htmlspecialchars($_GET["kml"]); ?></title>
    <style>
      html, body {
        height: 370px;
        padding: 0;
        margin: 0;
        }
      #map {
       height: 360px;
       width: 300px;
       overflow: hidden;
       float: left;
       border: thin solid #333;
       }
      #capture {
       height: 360px;
       width: 480px;
       overflow: hidden;
       float: left;
       background-color: #ECECFB;
       border: thin solid #333;
       border-left: none;
       }
       .img {
       width: 600px;
       height: 600px;
       }
              @media only screen and (max-width: 600px) {
       .img {
       width: 390px;
       height: 490px;
       }
       }
       .basi {
       display: inline-block;
       margin-top: 50px;
       }
       .basi h1 {
       font-size: 40pt;
       }
   </style></head>
  <body>
      <?php 
error_reporting(0);
if(empty(htmlspecialchars($_GET["kml"]))) {
echo '<h1 class="text-center mt-4">SatBeams Datamap</h1>';
} else {
  $var_olan  = array(".php", ".kml");
  $data = str_replace($var_olan, ' ', htmlspecialchars($_GET["kml"]));
echo '<h1 class="text-center mt-4">'.$data.' Datamap</h1>';
}
?>
  <hr class="container"></hr>
  <center><div class="btn-group" role="group" aria-label="Basic example">
      <a href="get.zip" class="btn btn-danger mt-2 text-center">Get All Files</a><br>
  <button type="button" class="btn btn-danger mt-2 text-center" onclick="window.history.go(-1); return false;">Go Back</button>
  </div></center>
  <div class="container overflow-hidden">
  <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 mt-4">
<?php 

if(empty(htmlspecialchars($_GET["kml"]))) {
  $mydir = '.'; 
  
  $myfiles = array_diff(scandir($mydir), array('.', '..')); 
  $var_olan  = array(".php", "son", "L.KML.js", "get", "leaflet", ".sql", ".png", ".zip");
  $data = str_replace($var_olan, '', $myfiles);
  foreach($data as $filename){
	if(is_file($filename)){
        echo '<div class="col-6"><div class="p-3 border bg-light"><a href="index.php?kml='.$filename.'">'.$filename.'</a></div></div><br>'; 
    }   
}

} else {
?>
<html>
    <head>
        <link rel="stylesheet" href="leaflet.css" />
        <script src="leaflet.js"></script>
        <script src="L.KML.js"></script>
    </head>
    <body>

        <div style="width: 100vw; height: 80vh" id="map"></div>
        <script type="text/javascript">
            // Make basemap
            const map = new L.Map('map', { center: new L.LatLng(58.4, 43.0), zoom: 11 });
            const osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            map.addLayer(osm);

            // Load kml file
            fetch('<?php echo htmlspecialchars($_GET["kml"]); ?>')
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    const track = new L.KML(kml);
                    map.addLayer(track);

                    // Adjust map to show the kml
                    const bounds = track.getBounds();
                    map.fitBounds(bounds);
                });
        </script>
        <center><img class="img" alt="diameter" src="data1.png"></center>
    </body>
</html>


<?php
}
?> 
  </div>
</div>
</br>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</html>