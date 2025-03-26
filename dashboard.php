<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome to the Dashboard</h1>

<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . $_SESSION["role"] . "</h2>";

if ($_SESSION["role"] == "monitoring_admin") {
    echo "<a href='manage_sensors.php'>Manage Sensors</a><br>";
    echo "<a href='alerts.php'>Set Alerts</a><br>";
} elseif ($_SESSION["role"] == "system_admin") {
    echo "<a href='user_management.php'>Manage Users</a><br>";
} elseif ($_SESSION["role"] == "public_user") {
    echo "<a href='public_map.php'>View AQI Data</a><br>";
}
?>

<a href="logout.php">Logout</a>

</body>
</html>
