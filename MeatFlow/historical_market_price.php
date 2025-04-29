<!DOCTYPE html>
<html>
<head>
    <title>Historical Market Price</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>📈 Historical Market Prices 📈</h2>

    <?php
    include 'db.php';
    ?>

    <h3>🔍 Search Historical Prices</h3>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by Batch Name or Production Date">
        <button type="submit">Search</button>
    </form>

    <hr>

    <table border="1" cellpadding="10">
        <tr>
            <th>Production Date</th>
            <th>Batch ID</th>
            <th>Batch Name</th>
            <th>Unit Price</th>
        </tr>
        <?php
        $sql = "SELECT ProductionDate, BatchID, BatchName, UnitPrice
                FROM PRODUCTION_BATCH";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
            $sql .= " WHERE BatchName LIKE '%$searchTerm%' OR ProductionDate LIKE '%$searchTerm%'";
        }
        $sql .= " ORDER BY ProductionDate DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                            <td>" . htmlspecialchars($row["ProductionDate"]) . "</td>
                            <td>" . htmlspecialchars($row["BatchID"]) . "</td>
                            <td>" . htmlspecialchars($row["BatchName"]) . "</td>
                            <td>" . htmlspecialchars($row["UnitPrice"]) . "</td>
                        </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>