<!DOCTYPE html>
<html>
<head>
    <title>Historical Production</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>🏭 Historical Production Data 🏭</h2>

    <?php
    include 'db.php';

    $edit_mode = false;
    $edit_BatchID = "";
    $edit_BatchName = "";
    $edit_ProductionDate = "";
    $edit_ExpiryDate = "";
    $edit_ProductionCost = "";
    $edit_ProductQuality = "";
    $edit_ProductYield = "";
    $edit_UnitPrice = ""; // Add UnitPrice to edit

    if (isset($_GET['edit'])) {
        $edit_mode = true;
        $edit_BatchID = $_GET['edit'];

        $sql = "SELECT * FROM PRODUCTION_BATCH WHERE BatchID = '$edit_BatchID'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $edit_BatchName = $row['BatchName'];
        $edit_ProductionDate = $row['ProductionDate'];
        $edit_ExpiryDate = $row['ExpiryDate'];
        $edit_ProductionCost = $row['ProductionCost'];
        $edit_ProductQuality = $row['ProductQuality'];
        $edit_ProductYield = $row['ProductYield'];
        $edit_UnitPrice = $row['UnitPrice']; // Get UnitPrice for edit
    }
    ?>

    <form method="POST" action="<?php echo $edit_mode ? 'update_historical_production.php' : 'insert_historical_production.php'; ?>">
        <input type="hidden" name="BatchID" value="<?php echo $edit_BatchID; ?>">
        <label for="BatchName">BatchName:</label><br>
        <input type="text" id="BatchName" name="BatchName" value="<?php echo $edit_BatchName; ?>" required><br>
        <label for="ProductionDate">ProductionDate:</label><br>
        <input type="text" id="ProductionDate" name="ProductionDate" value="<?php echo $edit_ProductionDate; ?>" required><br>
        <label for="ExpiryDate">ExpiryDate:</label><br>
        <input type="text" id="ExpiryDate" name="ExpiryDate" value="<?php echo $edit_ExpiryDate; ?>" required><br>
        <label for="ProductionCost">ProductionCost:</label><br>
        <input type="text" id="ProductionCost" name="ProductionCost" value="<?php echo $edit_ProductionCost; ?>" required><br>
        <label for="ProductQuality">ProductQuality:</label><br>
        <input type="text" id="ProductQuality" name="ProductQuality" value="<?php echo $edit_ProductQuality; ?>" required><br>
        <label for="ProductYield">ProductYield:</label><br>
        <input type="text" id="ProductYield" name="ProductYield" value="<?php echo $edit_ProductYield; ?>" required><br>
        <label for="UnitPrice">UnitPrice:</label><br>
        <input type="text" id="UnitPrice" name="UnitPrice" value="<?php echo $edit_UnitPrice; ?>" required><br>
        <button type="submit"><?php echo $edit_mode ? 'Update Batch' : 'Add Batch'; ?></button>
    </form>

    <hr>

    <h3>🔍 Search Production Batches</h3>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Enter batch name or production date">
        <button type="submit">Search</button>
    </form>

    <hr>

    <h3>📋 Production Batches</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>BatchID</th>
            <th>BatchName</th>
            <th>ProductionDate</th>
            <th>ExpiryDate</th>
            <th>ProductionCost</th>
            <th>ProductQuality</th>
            <th>ProductYield</th>
            <th>UnitPrice</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM PRODUCTION_BATCH";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
            $sql .= " WHERE BatchName LIKE '%$searchTerm%' OR ProductionDate LIKE '%$searchTerm%'";
        }
        $sql .= " ORDER BY BatchID DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['BatchID']) . "</td>
                    <td>" . htmlspecialchars($row['BatchName']) . "</td>
                    <td>" . htmlspecialchars($row['ProductionDate']) . "</td>
                    <td>" . htmlspecialchars($row['ExpiryDate']) . "</td>
                    <td>" . htmlspecialchars($row['ProductionCost']) . "</td>
                    <td>" . htmlspecialchars($row['ProductQuality']) . "</td>
                    <td>" . htmlspecialchars($row['ProductYield']) . "</td>
                    <td>" . htmlspecialchars($row['UnitPrice']) . "</td>
                    <td>
                        <a href='historical_production.php?edit=" . $row['BatchID'] . "'>Update</a> |
                        <a href='delete_historical_production.php?BatchID=" . $row['BatchID'] . "' onclick=\"return confirm('Delete this batch?');\">Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="historical_production_charts.php" class="view-charts-btn">📊 View Chart</a>
    </div>

    
</body>
</html>