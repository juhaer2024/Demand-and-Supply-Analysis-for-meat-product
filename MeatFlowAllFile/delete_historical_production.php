<?php
include 'db.php';

if (isset($_GET['BatchID'])) {
    $BatchID = $_GET['BatchID'];

    $sql = "DELETE FROM PRODUCTION_BATCH WHERE BatchID='$BatchID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: historical_production.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>