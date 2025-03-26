<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "monitoring_admin") {
    echo "Access Denied!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST["location"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $aqi_value = $_POST["aqi_value"];

    // Determine AQI Category
    if ($aqi_value <= 50) $category = "Good";
    elseif ($aqi_value <= 100) $category = "Moderate";
    elseif ($aqi_value <= 150) $category = "Unhealthy for Sensitive Groups";
    else $category = "Unhealthy";

    $query = "INSERT INTO sensors (location, latitude, longitude, aqi_value, category) 
              VALUES ('$location', $latitude, $longitude, $aqi_value, '$category')";

    if ($conn->query($query)) {
        header("Location: manage_sensors.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Sensor</title>
</head>
<body>

<h2>Add New Sensor</h2>
<a href="manage_sensors.php">Back to Sensors</a>

<form method="POST">
    <label>Location:</label>
    <input type="text" name="location" required><br>

    <label>Latitude:</label>
    <input type="text" name="latitude" required><br>

    <label>Longitude:</label>
    <input type="text" name="longitude" required><br>

    <label>AQI Value:</label>
    <input type="number" name="aqi_value" required><br>

    <input type="submit" value="Add Sensor">
</form>

</body>
</html>
