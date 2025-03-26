<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "air_quality_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch air quality data
$query = "SELECT * FROM sensors";
$result = $conn->query($query);

// Check if data exists
if ($result->num_rows > 0) {
    $sensors = array();
    while($row = $result->fetch_assoc()) {
        $sensors[] = $row; // Add each row to the sensors array
    }
    // Return data as JSON
    echo json_encode($sensors);
} else {
    echo json_encode([]); // Return empty array if no data found
}

// Close the connection
$conn->close();
?>
