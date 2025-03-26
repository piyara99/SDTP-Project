<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Monitoring Dashboard</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        #map {
            height: 500px;
            width: 90%;
            margin: 20px auto;
            border-radius: 10px;
        }
        .nav-links a {
            margin: 10px;
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
        }
        .nav-links a:hover {
            color: #0056b3;
        }
        .logout {
            display: block;
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Welcome to the Air Quality Dashboard</h1>
    <h2>Role: <?php echo ucfirst($_SESSION["role"]); ?></h2>

    <div class="nav-links">
        <?php if ($_SESSION["role"] == "monitoring_admin") { ?>
            <a href="manage_sensors.php">Manage Sensors</a>
            <a href="alerts.php">Set Alerts</a>
        <?php } elseif ($_SESSION["role"] == "system_admin") { ?>
            <a href="user_management.php">Manage Users</a>
        <?php } elseif ($_SESSION["role"] == "public_user") { ?>
            <a href="public_map.php">View AQI Data</a>
        <?php } ?>
    </div>

    <div id="map"></div>

    <a href="logout.php" class="logout">Logout</a>

    <script>
        var map = L.map('map').setView([6.9271, 79.8612], 12); // Colombo coordinates

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Fetch and display AQI data
        fetch('simulate_data.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(sensor => {
                    let color = sensor.aqi <= 50 ? 'green' :
                                sensor.aqi <= 100 ? 'yellow' :
                                sensor.aqi <= 150 ? 'orange' : 'red';

                    let marker = L.circleMarker([sensor.lat, sensor.lng], {
                        color: color,
                        fillColor: color,
                        fillOpacity: 0.8,
                        radius: 10
                    }).addTo(map);

                    marker.bindPopup(`
                        <b>${sensor.location}</b><br>
                        AQI: ${sensor.aqi} (${sensor.category})
                    `);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    </script>

</body>
</html>
