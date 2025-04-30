<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProductID = $_POST['ProductID'];
    $ProductName = $_POST['ProductName'];
    $ProductOrigin = $_POST['ProductOrigin'];
    $ProductType = $_POST['ProductType'];
    $ProductPrice = $_POST['ProductPrice'];
    $ProductSeasonality = $_POST['ProductSeasonality'];

    $sql = "UPDATE MEAT_PRODUCT 
            SET ProductName='$ProductName', ProductOrigin='$ProductOrigin', ProductType='$ProductType', 
                ProductPrice='$ProductPrice', ProductSeasonality='$ProductSeasonality' 
            WHERE ProductID='$ProductID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: productinfo.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>