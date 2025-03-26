<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "monitoring_admin") {
    echo "Access Denied!";
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $query = "SELECT * FROM sensors WHERE id=$id";
    $result = $conn->query($query);
    $sensor = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $location = $_POST["location"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $aqi_value = $_POST["aqi_value"];

    if ($aqi_value <= 50) $category = "Good";
    elseif ($aqi_value <= 100) $category = "Moderate";
    elseif ($aqi_value <= 150) $category = "Unhealthy for Sensitive Groups";
    else $category = "Unhealthy";

    $query = "UPDATE sensors SET location='$location', latitude=$latitude, longitude=$longitude, aqi_value=$aqi_value, category='$category' WHERE id=$id";

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
    <title>Edit Sensor</title>
</head>
<body>

<h2>Edit Sensor</h2>
<a href="manage_sensors.php">Back to Sensors</a>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $sensor['id']; ?>">
    
    <label>Location:</label>
    <input type="text" name="location" value="<?php echo $sensor['location']; ?>" required><br>

    <label>Latitude:</label>
    <input type="text" name="latitude" value="<?php echo $sensor['latitude']; ?>" required><br>

    <label>Longitude:</label>
    <input type="text" name="longitude" value="<?php echo $sensor['longitude']; ?>" required><br>

    <label>AQI Value:</label>
    <input type="number" name="aqi_value" value="<?php echo $sensor['aqi_value']; ?>" required><br>

    <input type="submit" value="Update Sensor">
</form>

</body>
</html>
