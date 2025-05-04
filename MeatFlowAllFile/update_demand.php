<?php
include 'db.php';

$id = $_POST['demand_id'];
$year = $_POST['year'];
$region = $_POST['region'];
$demand_tons = $_POST['demand_tons'];
$pattern = $_POST['consumption_pattern'];
$elasticity = $_POST['price_elasticity'];
$product_id = $_POST['product_id'];

$sql = "UPDATE demand 
        SET Year='$year', Region='$region', Demand='$demand_tons', 
            ConsumptionPattern='$pattern', PriceElasticity='$elasticity', ProductID='$product_id'
        WHERE DemandID = $id";

if ($conn->query($sql)) {
    header("Location: demand.php");
} else {
    echo "Error: " . $conn->error;
}
?>