<!DOCTYPE html>
<html>
<head>
    <title>Supply Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>🚚 Supply Information 📦</h2>

    <?php
    include 'db.php';

    // SQL query to join the tables and retrieve the required data
    $sql = "SELECT 
        d.DeliveryID AS SupplyID,
        d.DeliveryDate AS Date,
        d.DeliveryQuantity AS Quantity,
        d.DeliveryStatus AS Status,
        pb.BatchID AS 'Batch ID',
        pb.BatchName AS 'Batch Name',
        v.VendorName AS 'Vendor Name'
    FROM DELIVERY d
    JOIN VENDOR v ON d.VendorID = v.VendorID
    JOIN PRODUCTION_BATCH pb ON d.BatchID = pb.BatchID
    ORDER BY d.DeliveryID DESC";  //Added Order by clause

    $result = $conn->query($sql);
    ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>Supply ID</th>
            <th>Date</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Batch ID</th>
            <th>Batch Name</th>
            <th>Vendor Name</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row["SupplyID"]) . "</td>
                    <td>" . htmlspecialchars($row["Date"]) . "</td>
                    <td>" . htmlspecialchars($row["Quantity"]) . "</td>
                    <td>" . htmlspecialchars($row["Status"]) . "</td>
                    <td>" . htmlspecialchars($row["Batch ID"]) . "</td>
                    <td>" . htmlspecialchars($row["Batch Name"]) . "</td>
                    <td>" . htmlspecialchars($row["Vendor Name"]) . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No supplies found</td></tr>"; // added no data found
        }
        ?>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="supply_charts.php" class="view-charts-btn">📊 View Chart</a>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
