<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; }
        #dashboard { margin-top: 20px; }
        #legend { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Colombo Air Quality Monitoring</h2>
    <div id="map"></div>
    
    <!-- AQI Legend -->
    <div id="legend">
        <h4>AQI Levels</h4>
        <p><span style="background-color: green; width: 15px; height: 15px; display: inline-block;"></span> Good (0-50)</p>
        <p><span style="background-color: yellow; width: 15px; height: 15px; display: inline-block;"></span> Moderate (51-100)</p>
        <p><span style="background-color: orange; width: 15px; height: 15px; display: inline-block;"></span> Unhealthy for Sensitive Groups (101-150)</p>
        <p><span style="background-color: red; width: 15px; height: 15px; display: inline-block;"></span> Unhealthy (151-200)</p>
    </div>

    <!-- Dashboard -->
    <div id="dashboard">
        <h3>Real-Time AQI Dashboard</h3>
        <div>
            <h4>Overall AQI Status</h4>
            <p><strong>Good:</strong> <span class="good-count">0</span></p>
            <p><strong>Moderate:</strong> <span class="moderate-count">0</span></p>
            <p><strong>Unhealthy for Sensitive Groups:</strong> <span class="unhealthy-sensitive-count">0</span></p>
            <p><strong>Unhealthy:</strong> <span class="unhealthy-count">0</span></p>
        </div>
        <div>
            <h4>Historical Data</h4>
            <button id="view-historical">View Historical Trends</button>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([6.9271, 79.8612], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        fetch('fetch_aqi.php')
            .then(response => response.json())
            .then(data => {
                let goodCount = 0, moderateCount = 0, unhealthyCount = 0, unhealthySensitiveCount = 0;

                data.forEach(sensor => {
                    let color = sensor.aqi_value <= 50 ? 'green' : sensor.aqi_value <= 100 ? 'yellow' : sensor.aqi_value <= 150 ? 'orange' : 'red';
                    L.circleMarker([sensor.latitude, sensor.longitude], { color: color, radius: 8 })
                        .bindPopup(`Location: ${sensor.location}<br>AQI: ${sensor.aqi_value}`)
                        .addTo(map);

                    // Update counts for the dashboard
                    if (sensor.aqi_value <= 50) {
                        goodCount++;
                    } else if (sensor.aqi_value <= 100) {
                        moderateCount++;
                    } else if (sensor.aqi_value <= 150) {
                        unhealthySensitiveCount++;
                    } else {
                        unhealthyCount++;
                    }
                });

                // Update the dashboard with counts
                document.querySelector(".good-count").innerText = goodCount;
                document.querySelector(".moderate-count").innerText = moderateCount;
                document.querySelector(".unhealthy-sensitive-count").innerText = unhealthySensitiveCount;
                document.querySelector(".unhealthy-count").innerText = unhealthyCount;
            })
            .catch(error => {
                console.log("Error fetching data:", error);
            });
    </script>
</body>
</html>
