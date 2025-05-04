<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM recommendation WHERE RecommendationID = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: recommendation.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>