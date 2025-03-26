<?php
include 'config.php';

for ($i = 1; $i <= 5; $i++) {
    $lat = 6.9271 + rand(-5,5)/100;
    $lng = 79.8612 + rand(-5,5)/100;
    $aqi = rand(30, 200);
    $category = $aqi <= 50 ? "Good" : ($aqi <= 100 ? "Moderate" : ($aqi <= 150 ? "Unhealthy for Sensitive Groups" : "Unhealthy"));

    $conn->query("INSERT INTO sensors (location, latitude, longitude, aqi_value, category) VALUES ('Location $i', $lat, $lng, $aqi, '$category')");
}
?>
