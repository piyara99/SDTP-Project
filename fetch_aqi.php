<?php
include 'config.php';
header("Content-Type: application/json");

$result = $conn->query("SELECT * FROM sensors ORDER BY timestamp DESC LIMIT 50");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
