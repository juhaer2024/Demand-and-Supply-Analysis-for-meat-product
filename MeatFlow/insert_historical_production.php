<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $BatchName = $_POST['BatchName'];
    $ProductionDate = $_POST['ProductionDate'];
    $ExpiryDate = $_POST['ExpiryDate'];
    $ProductionCost = $_POST['ProductionCost'];
    $ProductQuality = $_POST['ProductQuality'];
    $ProductYield = $_POST['ProductYield'];
    $UnitPrice = $_POST['UnitPrice']; // Get UnitPrice

    $sql = "INSERT INTO PRODUCTION_BATCH (BatchName, ProductionDate, ExpiryDate, ProductionCost, ProductQuality, ProductYield, UnitPrice) 
            VALUES ('$BatchName', '$ProductionDate', '$ExpiryDate', '$ProductionCost', '$ProductQuality', '$ProductYield', '$UnitPrice')"; // Include UnitPrice

    if ($conn->query($sql) === TRUE) {
        header("Location: historical_production.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>