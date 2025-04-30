<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DeliveryID = $_POST['DeliveryID'];
    $DeliveryDate = $_POST['DeliveryDate'];
    $DeliveryStatus = $_POST['DeliveryStatus'];
    $DeliveryQuantity = $_POST['DeliveryQuantity'];
    $VendorID = $_POST['VendorID'];
    $BatchID = $_POST['BatchID'];
    $StorageID = $_POST['StorageID'];

    $sql = "UPDATE DELIVERY 
            SET DeliveryDate='$DeliveryDate', DeliveryStatus='$DeliveryStatus', DeliveryQuantity='$DeliveryQuantity', 
                VendorID='$VendorID', BatchID='$BatchID', StorageID='$StorageID'
            WHERE DeliveryID='$DeliveryID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: delivery.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
