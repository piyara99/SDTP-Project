<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "air_quality_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sensors = [1, 2, 3]; // Sensor IDs
foreach ($sensors as $sensor_id) {
    $aqi_value = rand(10, 300); // Generate random AQI values
    $sql = "INSERT INTO aqi_data (sensor_id, aqi_value) VALUES ($sensor_id, $aqi_value)";
    $conn->query($sql);
}

echo "Simulated data added.";
$conn->close();
?>
