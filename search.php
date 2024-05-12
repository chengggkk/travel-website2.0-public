<style>
    /* Style for the search result container */
.search-result {
    margin-bottom: 10px;
}

/* Style for the search result link */
.search-link {
    text-decoration: none;
    color: inherit;
}

/* Style for the search result item */
.search-item {
    background-color: #f8f8f8;
    padding: 5px 10px;
    border-radius: 3px;
}

/* Hover effect for the search result */
.search-item:hover {
    background-color: #ebebeb;
}
</style>
<?php
// search.php

$link = mysqli_connect('localhost', 'root', '12345678', 'travel');

$searchQuery = $_POST['query'];
$sql = "SELECT * FROM location WHERE loca_name LIKE '%$searchQuery%'";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='search-result'>";
    echo "<a href='search_result.php?location_id={$row['location_id']}' class='search-link'>";
    echo "<div class='search-item'>";
    echo "{$row['loca_name']}";
    echo "<br>";
    echo "<span style='font-size: 16px; color: gray;'>{$row['loca_address']}</span>";
    echo "</div>";
    echo "</a>";
    echo "</div>";
}

?>
