<?php
include 'db.php';

$year = $_POST['year'];
$region = $_POST['region'];
$demand_tons = $_POST['demand_tons'];
$pattern = $_POST['consumption_pattern'];
$elasticity = $_POST['price_elasticity'];
$product_id = $_POST['product_id'];

$sql = "INSERT INTO demand (Year, Region, Demand, ConsumptionPattern, PriceElasticity, ProductID)
        VALUES ('$year', '$region', '$demand_tons', '$pattern', '$elasticity', '$product_id')";

if ($conn->query($sql)) {
    header("Location: demand.php");
} else {
    echo "Error: " . $conn->error;
}
?>