<?php
session_start();
include 'config.php'; 

// Check if user is Monitoring Admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "monitoring_admin") {
    echo "Access Denied!";
    exit();
}

// Fetch sensors
$query = "SELECT * FROM sensors";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sensors</title>
</head>
<body>

<h2>Sensor Management</h2>
<a href="dashboard.php">Back to Dashboard</a> | 
<a href="add_sensor.php">Add New Sensor</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Location</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>AQI Value</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["location"]; ?></td>
        <td><?php echo $row["latitude"]; ?></td>
        <td><?php echo $row["longitude"]; ?></td>
        <td><?php echo $row["aqi_value"]; ?></td>
        <td><?php echo $row["category"]; ?></td>
        <td>
            <a href="edit_sensor.php?id=<?php echo $row["id"]; ?>">Edit</a> |
            <a href="delete_sensor.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
