<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $BatchID = $_POST['BatchID'];
    $BatchName = $_POST['BatchName'];
    $ProductionDate = $_POST['ProductionDate'];
    $ExpiryDate = $_POST['ExpiryDate'];
    $ProductionCost = $_POST['ProductionCost'];
    $ProductQuality = $_POST['ProductQuality'];
    $ProductYield = $_POST['ProductYield'];
    $UnitPrice = $_POST['UnitPrice']; // Get UnitPrice

    $sql = "UPDATE PRODUCTION_BATCH 
            SET BatchName='$BatchName', ProductionDate='$ProductionDate', ExpiryDate='$ExpiryDate', 
                ProductionCost='$ProductionCost', ProductQuality='$ProductQuality', ProductYield='$ProductYield', UnitPrice='$UnitPrice'
            WHERE BatchID='$BatchID'"; // Include UnitPrice

    if ($conn->query($sql) === TRUE) {
        header("Location: historical_production.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>