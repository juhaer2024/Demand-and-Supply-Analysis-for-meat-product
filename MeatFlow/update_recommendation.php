<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $reasoning = $_POST['reasoning'];
    $date = $_POST['date'];
    $farmid = $_POST['farmid'];
    $officerid = $_POST['officerid'];

    $sql = "UPDATE recommendation SET 
            SuggestedAction='$action', 
            Reasoning='$reasoning', 
            RecommendationDate='$date', 
            FarmID='$farmid', 
            GovernmentOfficerID='$officerid'
            WHERE RecommendationID=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: recommendation.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>