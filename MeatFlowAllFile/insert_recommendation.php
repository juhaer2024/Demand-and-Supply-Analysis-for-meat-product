<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $reasoning = $_POST['reasoning'];
    $date = $_POST['date'];
    $farmid = $_POST['farmid'];
    $officerid = $_POST['officerid'];

    $sql = "INSERT INTO recommendation (SuggestedAction, Reasoning, RecommendationDate, FarmID, GovernmentOfficerID) 
            VALUES ('$action', '$reasoning', '$date', '$farmid', '$officerid')";

    if ($conn->query($sql) === TRUE) {
        header("Location: recommendation.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>