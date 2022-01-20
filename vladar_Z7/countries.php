<?php
require ('database.php');
session_start();

if (!isset($_SESSION['access']) || $_SESSION['access'] == false) {
    header("Location: ./index.php");
}
$conn = (new Database())->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT COUNT(country) as pocet, country FROM visites GROUP BY country";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $visites = $stmt->fetchAll();


$query2 = "SELECT local_time FROM visites ";

$stmt2 = $conn->prepare($query2);
$stmt2->execute();
$times = $stmt2->fetchAll();

$query3 = "SELECT type,longitude, latitude, city FROM visites ";

$stmt3 = $conn->prepare($query3);
$stmt3->execute();
$types = $stmt3->fetchAll();
?>
<!DOCTYPE html>
<html lang="sk">
<head>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""
    >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #mapid{
            width: 100%;
            height: 500px;
            margin-bottom: 10rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="weather" href="weather.php">Počasie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id ="ip_adress" href="ip.php">IP Adresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id ="countries" href="countries.php">Krajiny</a>
                    </li>
                </ul>
            </div>
        </nav>
        <table id="table_data" class = "table table-striped">
            <thead>
            <tr>
                <th>Vlajka</th>
                <th>Krajina</th>
                <th>Počet návštev</th>

            </tr>

            </thead>
            <tbody>



            <?php
            foreach ($visites as $visit){

                    $country = strtolower($visit['country']);
                    echo '<tr>';
                    echo '<td><img src="http://www.geonames.org/flags/x/'. $country .'.gif" width="350px" height="200px"></img></td>';
                    echo '<td><a  href="cities.php?country='.$visit['country'].'">'.$visit['country'].'</a></td>';
                    echo '<td>'.$visit['pocet'].'</td>';
                    echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <table id="" class = "table table-striped">
            <thead>
            <tr>
                <th>Čas</th>
                <th>Počet</th>
            </tr>
            </thead>
            <tbody>



            <?php
            $firstTime = 0;
            $secondTime = 0;
            $thirdTime = 0;
            $fourthTime = 0;
            foreach ($times as $time){

                $current_time = substr($time['local_time'],11);
                $current_time =  date( "H:i", strtotime( $current_time));

                $from = "0:00";
                $to = "5:59";

                $date2 =  date( "H:i", strtotime( $from));
                $date3 =  date( "H:i", strtotime( $to));

                if ($current_time > $date2 && $current_time < $date3)
                {
                   $firstTime++;
                }
                $from = "6:00";
                $to = "11:59";

                $date2 =  date( "H:i", strtotime( $from));
                $date3 =  date( "H:i", strtotime( $to));
                if ($current_time > $date2 && $current_time < $date3)
                {
                    $secondTime++;
                }
                $from = "12:00";
                $to = "15:59";

                $date2 =  date( "H:i", strtotime( $from));
                $date3 =  date( "H:i", strtotime( $to));
                if ($current_time > $date2 && $current_time < $date3)
                {
                    $thirdTime++;
                }
                $from = "16:00";
                $to = "23:59";

                $date2 =  date( "H:i", strtotime( $from));
                $date3 =  date( "H:i", strtotime( $to));
                if ($current_time > $date2 && $current_time < $date3)
                {
                    $fourthTime++;
                }


            }
            echo '<tr>';
            echo '<td>00:00 - 05:59</td>';
            echo '<td>'.$firstTime.'</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>06:00 - 11:59</td>';
            echo '<td>'.$secondTime.'</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>12:00 - 15:59</td>';
            echo '<td>'.$thirdTime.'</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>16:00 - 23:59</td>';
            echo '<td>'.$fourthTime.'</td>';
            echo '</tr>';
            ?>
            </tbody>
        </table>
        <table id="" class = "table table-striped">
            <thead>
            <tr>
                <th>Typ</th>
                <th>Počet</th>
            </tr>
            </thead>
            <tbody>



            <?php
            $ip = 0;
            $weather = 0;
            $countries = 0;
            foreach ($types as $type){
                if($type['type'] == "ip"){
                    $ip++;
                }
                if($type['type'] == "weather"){
                    $weather++;
                }
                if($type['type'] == "countries"){
                    $countries++;
                }



            }
            echo '<tr>';
            echo '<td>IP</td>';
            echo '<td>'.$ip.'</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>WEATHER</td>';
            echo '<td>'.$weather.'</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>COUNTRIES</td>';
            echo '<td>'.$countries.'</td>';
            echo '</tr>';

            ?>
            </tbody>
        </table>
        <div id="mapid"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity=""></script>
<script src="script.js" integrity=""></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""
></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@2.5.1/dist/esri-leaflet.js"
  integrity="sha512-q7X96AASUF0hol5Ih7AeZpRF6smJS55lcvy+GLWzJfZN+31/BQ8cgNx2FGF+IQSA4z2jHwB20vml+drmooqzzQ=="
  crossorigin=""></script>

<!-- Load Esri Leaflet Geocoder from CDN -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
  integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
  crossorigin="">
<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
  integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
  crossorigin=""></script> 
<script>
    <?php
        $locations = json_encode($types);
    ?>
    document.addEventListener('DOMContentLoaded', function () {
        const locations = JSON.parse('<?php echo "$locations"?>')
        const featureGeos = locations.map(loc => {
            return {
                type: "Feature",
                properties: {
                    popupContent: loc.city
                },
                geometry: {
                    type: "Point",
                    coordinates: [ loc.longitude, loc.latitude ]
                }
            }
        })
        const geoObject = {
            type: "FeatureCollection",
            features: featureGeos
        }
        var mymap = L.map('mapid').setView([48.1526517, 17.0731925], 2);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoianZsYWRhciIsImEiOiJja2d3OGZ4MGcwN29hMnFxaG5zaXk3ZDF5In0.edZqRmwFbi3ZZUshTWYnXQ'
        }).addTo(mymap);

        L.geoJSON(geoObject, {
            pointToLayer: function (feature, latlng) {
            return L.marker(latlng, { icon: busIcon});
            }, onEachFeature: onEachFeature
        }).addTo(mymap);

        const searchControl = L.esri.Geocoding.geosearch().addTo(mymap);

        const results = L.layerGroup().addTo(mymap);

        searchControl.on('results', function (data) {
            results.clearLayers();
            for (var i = data.results.length - 1; i >= 0; i--) {
            results.addLayer(L.marker(data.results[i].latlng));

            L.Routing.control({
                waypoints: [
                L.latLng(48.15189, 17.07349),
                data.results[i].latlng
                ]
            }).addTo(mymap);

            }
        })
    })
    
    const busIcon = L.icon({
    iconUrl: "https://freeiconshop.com/wp-content/uploads/edd/location-pin-compact-solid.png",
    iconSize: [30, 30],
    iconAnchor: [10, 10],
    popupAnchor: [0, -10]
    });

    function onEachFeature(feature, layer) {
        if (feature.properties && feature.properties.popupContent) {
            layer.bindPopup(feature.properties.popupContent);
        }
    }
</script>
</body>
</html>