<?php session_start();

if (isset($_SESSION['message'])) {
    echo '<script>alert("' . $_SESSION['message'] . '");</script>';
    unset($_SESSION['message']);
}
require 'api-key.php';

?>
<!DOCTYPE html>
<html>

<head>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            color: black;
            padding: 20px;
            height: 900px;
            border-radius: 5px;
        }

        input[type="submit"] {
            margin-top: 10px;
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="modal.css">
    <script src="https://kit.fontawesome.com/29a6af0e63.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>新增景點</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div style="display: flex; justify-content: center; margin-top:2%;">
        <img src="https://i.pinimg.com/736x/2a/1a/87/2a1a878512e4b568d6cbc484bc5e32f5.jpg" alt="" style="width: 30%; height: 940px; border-radius: 5px;">
        <form method="post" action="process_add-loca.php">

            <h1>新增景點</h1><br>            
            <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#howtoadd">
                如何新增景點
            </button><br>
            Name: <input type="text" name="loca_name" required><br>
            Google Map Link:
            <input style="width: 400px;" type="text" name="loca_url"><br>
            輸入地址:
            <input id="searchInput" style="width:400px;" type="text" placeholder="搜尋景點、地址" name="loca_address" required>
            <div id="map" style="height: 800px; width: 100%;"></div>
            <script>
                function initAutocomplete() {
                    var input = document.getElementById('searchInput');
                    var autocomplete = new google.maps.places.Autocomplete(input);
                    
                    autocomplete.setTypes(['geocode']);
                    autocomplete.setFields(['address_components', 'geometry']);

                    var geocoder = new google.maps.Geocoder();

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
            <script  async
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&libraries=places&callback=initAutocomplete" async defer></script>
            <input type="submit" class="button">
        </form>
        <!-- Modal -->
        <div class="modal fade" id="howtoadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">如何新增景點</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class='fa-solid fa-xmark' ></i> </button>
                    </div>
                    <div class="modal-body">
                        <img src="img/howtoaddloca.jpg" alt="howtoaddloca" style="width: 100%; height: 100%; border-radius: 5px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>