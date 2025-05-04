<?php
include 'db.php';

if (isset($_GET['DeliveryID'])) {
    $DeliveryID = $_GET['DeliveryID'];

    $sql = "DELETE FROM DELIVERY WHERE DeliveryID='$DeliveryID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: delivery.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
