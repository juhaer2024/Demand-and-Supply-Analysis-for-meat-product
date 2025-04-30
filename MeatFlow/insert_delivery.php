<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DeliveryDate = $_POST['DeliveryDate'];
    $DeliveryStatus = $_POST['DeliveryStatus'];
    $DeliveryQuantity = $_POST['DeliveryQuantity'];
    $VendorID = $_POST['VendorID'];
    $BatchID = $_POST['BatchID'];
    $StorageID = $_POST['StorageID'];

    $sql = "INSERT INTO DELIVERY (DeliveryDate, DeliveryStatus, DeliveryQuantity, VendorID, BatchID, StorageID) 
            VALUES ('$DeliveryDate', '$DeliveryStatus', '$DeliveryQuantity', '$VendorID', '$BatchID', '$StorageID')";

    if ($conn->query($sql) === TRUE) {
        header("Location: delivery.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
