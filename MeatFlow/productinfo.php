<!DOCTYPE html>
<html>

<head>
    <title>Meat Product Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h2>🥩 Meat Product Information 🍖</h2>

    <?php
    include 'db.php';

    $edit_mode = false;
    $edit_ProductID = "";
    $edit_ProductName = "";
    $edit_ProductOrigin = "";
    $edit_ProductType = "";
    $edit_ProductPrice = "";
    $edit_ProductSeasonality = "";


    if (isset($_GET['edit'])) {
        $edit_mode = true;
        $edit_ProductID = $_GET['edit'];

        $sql = "SELECT * FROM MEAT_PRODUCT WHERE ProductID = '$edit_ProductID'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $edit_ProductName = $row['ProductName'];
        $edit_ProductOrigin = $row['ProductOrigin'];
        $edit_ProductType = $row['ProductType'];
        $edit_ProductPrice = $row['ProductPrice'];
        $edit_ProductSeasonality = $row['ProductSeasonality'];
    }
    ?>

    <form method="POST" action="<?php echo $edit_mode ? 'update_product.php' : 'insert_product.php'; ?>">
        <input type="hidden" name="ProductID" value="<?php echo $edit_ProductID; ?>">

        <label for="ProductName">Product Name:</label><br>
        <input type="text" id="ProductName" name="ProductName" value="<?php echo $edit_ProductName; ?>" required><br>

        <label for="ProductOrigin">Product Origin:</label><br>
        <input type="text" id="ProductOrigin" name="ProductOrigin" value="<?php echo $edit_ProductOrigin; ?>" required><br>

        <label for="ProductType">Product Type:</label><br>
        <input type="text" id="ProductType" name="ProductType" value="<?php echo $edit_ProductType; ?>" required><br>

        <label for="ProductPrice">Product Price (Tk.):</label><br>
        <input type="number" step="0.01" id="ProductPrice" name="ProductPrice" value="<?php echo $edit_ProductPrice; ?>"
            required><br>

        <label for="ProductSeasonality">Product Seasonality:</label><br>
        <input type="text" id="ProductSeasonality" name="ProductSeasonality"
            value="<?php echo $edit_ProductSeasonality; ?>"><br>

        <button type="submit"><?php echo $edit_mode ? 'Update Product' : 'Add Product'; ?></button>
    </form>

    <hr>

    <h3>🔍 Search Meat Products</h3>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Enter product name or type">
        <button type="submit">Search</button>
    </form>

    <hr>

    <h3>📋 Current Meat Products</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Origin</th>
            <th>Product Type</th>
            <th>Product Price (Tk.)</th>
            <th>Product Seasonality</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT * FROM MEAT_PRODUCT";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
            $sql .= " WHERE ProductName LIKE '%$searchTerm%' OR ProductType LIKE '%$searchTerm%'";
        }
        $sql .= " ORDER BY ProductID DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['ProductID']) . "</td>
                    <td>" . htmlspecialchars($row['ProductName']) . "</td>
                    <td>" . htmlspecialchars($row['ProductOrigin']) . "</td>
                    <td>" . htmlspecialchars($row['ProductType']) . "</td>
                    <td>" . htmlspecialchars($row['ProductPrice']) . "</td>
                    <td>" . htmlspecialchars($row['ProductSeasonality']) . "</td>
                    <td>
                        <a href='productinfo.php?edit=" . $row['ProductID'] . "'>Update</a> |
                        <a href='delete_product.php?ProductID=" . $row['ProductID'] . "' onclick=\"return confirm('Delete this product?');\">Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="productinfo_charts.php" class="view-charts-btn">📊 View Chart</a>
    </div>


    

</body>

</html>