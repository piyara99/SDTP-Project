<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "monitoring_admin") {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "air_quality_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sensor_name = $_POST["sensor_name"];
    $location = $_POST["location"];
    $status = $_POST["status"];

    $query = "INSERT INTO sensors (sensor_name, location, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $sensor_name, $location, $status);
    $stmt->execute();
}

$sensors = $conn->query("SELECT * FROM sensors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sensors</title>
</head>
<body>

<h2>Manage Sensors</h2>

<form method="POST">
    <input type="text" name="sensor_name" placeholder="Sensor Name" required>
    <input type="text" name="location" placeholder="Location" required>
    <select name="status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <button type="submit">Add Sensor</button>
</form>

<h3>Existing Sensors</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Sensor Name</th>
        <th>Location</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $sensors->fetch_assoc()): ?>
    <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["sensor_name"] ?></td>
        <td><?= $row["location"] ?></td>
        <td><?= $row["status"] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
