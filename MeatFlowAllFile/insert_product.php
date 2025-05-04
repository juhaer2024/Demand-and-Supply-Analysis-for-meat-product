<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProductName = $_POST['ProductName'];
    $ProductOrigin = $_POST['ProductOrigin'];
    $ProductType = $_POST['ProductType'];
    $ProductPrice = $_POST['ProductPrice'];
    $ProductSeasonality = $_POST['ProductSeasonality'];

    $sql = "INSERT INTO MEAT_PRODUCT (ProductName, ProductOrigin, ProductType, ProductPrice, ProductSeasonality) 
            VALUES ('$ProductName', '$ProductOrigin', '$ProductType', '$ProductPrice', '$ProductSeasonality')";

    if ($conn->query($sql) === TRUE) {
        header("Location: productinfo.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>