<?php
$conn = new mysqli("localhost", "root", "", "air_quality_db");
$sensors = $conn->query("SELECT * FROM sensors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public AQI Map</title>
</head>
<body>

<h2>Air Quality Monitoring</h2>
<table border="1">
    <tr>
        <th>Sensor Name</th>
        <th>Location</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $sensors->fetch_assoc()): ?>
    <tr>
        <td><?= $row["sensor_name"] ?></td>
        <td><?= $row["location"] ?></td>
        <td><?= $row["status"] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="index.php">Back to Home</a>

</body>
</html>
