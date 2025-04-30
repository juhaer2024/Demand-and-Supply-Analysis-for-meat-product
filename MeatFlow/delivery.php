<!DOCTYPE html>
<html>

<head>
    <title>Delivery Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h2>🚚 Delivery Information 📦</h2>

    <?php
    include 'db.php';

    $edit_mode = false;
    $edit_DeliveryID = "";
    $edit_DeliveryDate = "";
    $edit_DeliveryStatus = "";
    $edit_DeliveryQuantity = "";
    $edit_VendorID = "";
    $edit_BatchID = "";
    $edit_StorageID = "";


    if (isset($_GET['edit'])) {
        $edit_mode = true;
        $edit_DeliveryID = $_GET['edit'];

        $sql = "SELECT d.*, v.VendorName, pb.BatchName, cs.StorageName
                    FROM DELIVERY d
                    JOIN VENDOR v ON d.VendorID = v.VendorID
                    JOIN PRODUCTION_BATCH pb ON d.BatchID = pb.BatchID
                    JOIN COLDSTORAGE cs ON d.StorageID = cs.StorageID
                    WHERE d.DeliveryID = '$edit_DeliveryID'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $edit_DeliveryDate = $row['DeliveryDate'];
        $edit_DeliveryStatus = $row['DeliveryStatus'];
        $edit_DeliveryQuantity = $row['DeliveryQuantity'];
        $edit_VendorID = $row['VendorID'];
        $edit_BatchID = $row['BatchID'];
        $edit_StorageID = $row['StorageID'];
    }
    ?>

    <form method="POST" action="<?php echo $edit_mode ? 'update_delivery.php' : 'insert_delivery.php'; ?>">
        <input type="hidden" name="DeliveryID" value="<?php echo $edit_DeliveryID; ?>">

        <label for="DeliveryDate">Delivery Date:</label><br>
        <input type="date" id="DeliveryDate" name="DeliveryDate" value="<?php echo $edit_DeliveryDate; ?>" required><br>

        <label for="DeliveryStatus">Delivery Status:</label><br>
        <input type="text" id="DeliveryStatus" name="DeliveryStatus" value="<?php echo $edit_DeliveryStatus; ?>"
            required><br>

        <label for="DeliveryQuantity">Delivery Quantity:</label><br>
        <input type="number" id="DeliveryQuantity" name="DeliveryQuantity"
            value="<?php echo $edit_DeliveryQuantity; ?>" required><br>

        <label for="VendorID">Vendor Name:</label><br>
        <select id="VendorID" name="VendorID" required>
            <?php
            $vendor_sql = "SELECT VendorID, VendorName FROM VENDOR";
            $vendor_result = $conn->query($vendor_sql);
            while ($vendor_row = $vendor_result->fetch_assoc()) {
                $selected = ($vendor_row['VendorID'] == $edit_VendorID) ? "selected" : "";
                echo "<option value='" . $vendor_row['VendorID'] . "' " . $selected . ">" . htmlspecialchars($vendor_row['VendorName']) . "</option>";
            }
            ?>
        </select><br>

        <label for="BatchID">Batch Name:</label><br>
        <select id="BatchID" name="BatchID" required>
            <?php
            $batch_sql = "SELECT BatchID, BatchName FROM PRODUCTION_BATCH";
            $batch_result = $conn->query($batch_sql);
            while ($batch_row = $batch_result->fetch_assoc()) {
                $selected = ($batch_row['BatchID'] == $edit_BatchID) ? "selected" : "";
                echo "<option value='" . $batch_row['BatchID'] . "' " . $selected . ">" . htmlspecialchars($batch_row['BatchName']) . "</option>";
            }
            ?>
        </select><br>

        <label for="StorageID">Storage Name:</label><br>
        <select id="StorageID" name="StorageID" required>
            <?php
            $storage_sql = "SELECT StorageID, StorageName FROM COLDSTORAGE";
            $storage_result = $conn->query($storage_sql);
            while ($storage_row = $storage_result->fetch_assoc()) {
                $selected = ($storage_row['StorageID'] == $edit_StorageID) ? "selected" : "";
                echo "<option value='" . $storage_row['StorageID'] . "' " . $selected . ">" . htmlspecialchars($storage_row['StorageName']) . "</option>";
            }
            ?>
        </select><br>

        <button type="submit"><?php echo $edit_mode ? 'Update Delivery' : 'Add Delivery'; ?></button>
    </form>

    <hr>

    <h3>🔍 Search Deliveries</h3>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by Date, Status, Vendor, or Batch">
        <button type="submit">Search</button>
    </form>

    <hr>

    <h3>📋 Current Deliveries</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Delivery ID</th>
            <th>Delivery Date</th>
            <th>Delivery Status</th>
            <th>Delivery Quantity</th>
            <th>Vendor Name</th>
            <th>Batch Name</th>
            <th>Storage Name</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT d.*, v.VendorName, pb.BatchName, cs.StorageName
                    FROM DELIVERY d
                    JOIN VENDOR v ON d.VendorID = v.VendorID
                    JOIN PRODUCTION_BATCH pb ON d.BatchID = pb.BatchID
                    JOIN COLDSTORAGE cs ON d.StorageID = cs.StorageID";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
            $sql .= " WHERE d.DeliveryDate LIKE '%$searchTerm%'
                       OR d.DeliveryStatus LIKE '%$searchTerm%'
                       OR v.VendorName LIKE '%$searchTerm%'
                       OR pb.BatchName LIKE '%$searchTerm%'";
        }

        $sql .= " ORDER BY d.DeliveryID DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td>" . htmlspecialchars($row['DeliveryID']) . "</td>
                        <td>" . htmlspecialchars($row['DeliveryDate']) . "</td>
                        <td>" . htmlspecialchars($row['DeliveryStatus']) . "</td>
                        <td>" . htmlspecialchars($row['DeliveryQuantity']) . "</td>
                        <td>" . htmlspecialchars($row['VendorName']) . "</td>
                        <td>" . htmlspecialchars($row['BatchName']) . "</td>
                        <td>" . htmlspecialchars($row['StorageName']) . "</td>
                        <td>
                            <a href='delivery.php?edit=" . $row['DeliveryID'] . "'>Update</a> |
                            <a href='delete_delivery.php?DeliveryID=" . $row['DeliveryID'] . "' onclick=\"return confirm('Delete this delivery?');\">Delete</a>
                        </td>
                    </tr>";
        }
        ?>
    </table>
</body>

</html>