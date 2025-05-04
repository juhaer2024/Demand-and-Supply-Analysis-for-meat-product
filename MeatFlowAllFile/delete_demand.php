<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM demand WHERE DemandID = $id";

if ($conn->query($sql)) {
    header("Location: demand.php");
} else {
    echo "Error: " . $conn->error;
}
?>