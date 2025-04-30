<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Meat Demand Records</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js CDN -->
</head>
<body>

<h2>📋 Meat Demand Records</h2>

<div style="margin-bottom: 20px;">
    <a href="demand_form.php" class="button">➕ Add New Demand</a>
</div>

<table>
    <tr>
        <th>Year</th>
        <th>Region</th>
        <th>Product</th>
        <th>Demand</th>
        <th>Consumption Pattern</th>
        <th>Price Elasticity</th>
        <th>Actions</th>
    </tr>

    <?php
    $sql = "SELECT d.*, m.ProductName 
            FROM demand d 
            JOIN meat_product m ON d.ProductID = m.ProductID 
            ORDER BY d.DemandID DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['Year']) . "</td>
            <td>" . htmlspecialchars($row['Region']) . "</td>
            <td>" . htmlspecialchars($row['ProductName']) . "</td>
            <td>" . htmlspecialchars($row['Demand']) . "</td>
            <td>" . htmlspecialchars($row['ConsumptionPattern']) . "</td>
            <td>" . htmlspecialchars($row['PriceElasticity']) . "</td>
            <td>
                <a href='demand_form.php?edit=" . $row['DemandID'] . "'>Update</a> |
                <a href='delete_demand.php?id=" . $row['DemandID'] . "' onclick=\"return confirm('Delete this record?');\">Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>

<hr>


</body>
</html>

<?php
include 'db.php';

$edit_mode = false;
$edit_id = "";
$year = "";
$region = "";
$demand_tons = "";
$consumption_pattern = "";
$price_elasticity = "";
$product_id = "";

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM demand WHERE DemandID = $edit_id";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $year = $row['Year'];
        $region = $row['Region'];
        $demand_tons = $row['Demand'];
        $consumption_pattern = $row['ConsumptionPattern'];
        $price_elasticity = $row['PriceElasticity'];
        $product_id = $row['ProductID'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Demand Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>📝 Add/Update Meat Demand</h2>

<form method="POST" action="<?php echo $edit_mode ? 'update_demand.php' : 'insert_demand.php'; ?>">
    <input type="hidden" name="demand_id" value="<?php echo $edit_id; ?>">

    <label>Year:</label>
    <input type="number" name="year" value="<?php echo $year; ?>" required>

    <label>Region:</label>
    <input type="text" name="region" value="<?php echo $region; ?>" required>

    <label>Demand (tons):</label>
    <input type="number" step="0.01" name="demand_tons" value="<?php echo $demand_tons; ?>" required>

    <label>Consumption Pattern:</label>
    <textarea name="consumption_pattern"><?php echo $consumption_pattern; ?></textarea>

    <label>Price Elasticity:</label>
    <input type="number" step="0.01" name="price_elasticity" value="<?php echo $price_elasticity; ?>">

    <label>Meat Product:</label>
    <select name="product_id" required>
        <option value="">-- Select Product --</option>
        <?php
        $products = $conn->query("SELECT ProductID, ProductName FROM meat_product");
        while ($p = $products->fetch_assoc()) {
            $selected = ($p['ProductID'] == $product_id) ? 'selected' : '';
            echo "<option value='{$p['ProductID']}' $selected>{$p['ProductName']}</option>";
        }
        ?>
    </select>

    <button type="submit"><?php echo $edit_mode ? 'Update' : 'Add'; ?></button>
</form>
<br>


<div style="text-align: center; margin-top: 20px;">
    <a href="demand.php" class="button" style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">📋 View Demand Table</a>
</div>



</body>
</html>