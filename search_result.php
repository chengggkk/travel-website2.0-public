<?php
// search_result.php
require 'api-key.php';

$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

// Get the location_id from the URL
$location_id = $_GET['location_id'];

// Fetch the location details from the database
$sql = "SELECT * FROM location WHERE location_id = $location_id";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>查看景點資訊 - <?php echo "{$row['loca_name']}"; ?></title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div style="background-color:white; width:1300px; margin: 100px auto; justify-content: center; padding:50px; border-radius: 10px;">
        <?php
        echo "<h1>{$row['loca_name']}</h1>";
        echo "<p>{$row['loca_country']}</p>";
        echo "<p>{$row['loca_address']}</p>";
        echo "<a href='{$row['loca_url']}'>Google Maps連結</a>";
        ?>
        <input id="searchInput" style="width:1000px;" type="text" value="<?php echo $row['loca_address'] ?>">
        <div id="map" style="height: 400px; width: 100%;"></div>
        <script>
            function initAutocomplete() {
                var input = document.getElementById('searchInput');
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.setTypes(['geocode']);
                autocomplete.setFields(['address_components', 'geometry']);

                // Geocode the initial input value
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': input.value
                }, function(results, status) {
                    if (status == 'OK') {
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();

                        const position = {
                            lat: lat,
                            lng: lng
                        };
                        const map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 14,
                            center: position,
                        });

                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: input.value,
                        });
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    var lat = place.geometry.location.lat();
                    var lng = place.geometry.location.lng();

                    console.log('Latitude:', lat);
                    console.log('Longitude:', lng);

                    const position = {
                        lat: lat,
                        lng: lng
                    };
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 14,
                        center: position,
                    });

                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: place.name,
                    });
                });
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&libraries=places&callback=initAutocomplete" async defer></script>
    
        <form action="update_location.php">
    <input style="width: 1000px; border:none;" type="text" name="loca_info" value="在此編輯資訊">
    </form>
    </div>
</body>

</html>