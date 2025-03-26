<?php
session_start();
include 'config.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "monitoring_admin") {
    echo "Access Denied!";
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $conn->query("DELETE FROM sensors WHERE id=$id");
}

header("Location: manage_sensors.php");
?>
