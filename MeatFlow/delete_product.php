<?php
include 'db.php';

if (isset($_GET['ProductID'])) {
    $ProductID = $_GET['ProductID'];

    $sql = "DELETE FROM MEAT_PRODUCT WHERE ProductID='$ProductID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: productinfo.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>