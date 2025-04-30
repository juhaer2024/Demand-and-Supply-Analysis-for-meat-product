
<?php
include 'db.php';

$edit_mode = false;
$edit_id = "";
$edit_action = "";
$edit_reasoning = "";
$edit_date = "";
$edit_farmid = "";
$edit_officerid = "";

// Edit mode check
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM recommendation WHERE RecommendationID = $edit_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $edit_action = $row['SuggestedAction'];
    $edit_reasoning = $row['Reasoning'];
    $edit_date = $row['RecommendationDate'];
    $edit_farmid = $row['FarmID'];
    $edit_officerid = $row['GovernmentOfficerID'];
}

// Fetch farms
$farm_sql = "SELECT FarmID, FarmName FROM farm";
$farm_result = $conn->query($farm_sql);

// Fetch officers
$officer_sql = "SELECT GovernmentOfficerID, OfficerName FROM governmentofficer";
$officer_result = $conn->query($officer_sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Recommendationss</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>📋 Recommendations</h2>

<form method="POST" action="<?php echo $edit_mode ? 'update_recommendation.php' : 'insert_recommendation.php'; ?>">
    <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

    <input type="text" name="action" placeholder="Suggested Action" value="<?php echo $edit_action; ?>" required>
    <input type="text" name="reasoning" placeholder="Reasoning" value="<?php echo $edit_reasoning; ?>" required>
    <input type="date" name="date" value="<?php echo $edit_date; ?>" required>

    <!-- FarmID Dropdown -->
    <select name="farmid" required>
        <option value="">Select Farm</option>
        <?php while ($farm = $farm_result->fetch_assoc()) { ?>
            <option value="<?php echo $farm['FarmID']; ?>" <?php if ($edit_farmid == $farm['FarmID']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($farm['FarmName']); ?>
            </option>
        <?php } ?>
    </select>

    <!-- GovernmentOfficerID Dropdown -->
    <select name="officerid" required>
        <option value="">Select Officer</option>
        <?php while ($officer = $officer_result->fetch_assoc()) { ?>
            <option value="<?php echo $officer['GovernmentOfficerID']; ?>" <?php if ($edit_officerid == $officer['GovernmentOfficerID']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($officer['OfficerName']); ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit"><?php echo $edit_mode ? 'Update' : 'Add'; ?></button>
</form>

<hr>

<!-- Table to display existing recommendations -->
<table border="1" cellpadding="10">
    <tr>
        <th>Suggested Action</th>
        <th>Reasoning</th>
        <th>Date</th>
        <th>Farm</th>
        <th>Officer</th>
        <th>Actions</th>
    </tr>

    <?php
    $sql = "SELECT * FROM recommendation ORDER BY RecommendationID DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['SuggestedAction']) . "</td>
            <td>" . htmlspecialchars($row['Reasoning']) . "</td>
            <td>" . htmlspecialchars($row['RecommendationDate']) . "</td>
            <td>" . htmlspecialchars($row['FarmID']) . "</td>
            <td>" . htmlspecialchars($row['GovernmentOfficerID']) . "</td>
            <td>
                <a href='recommendation.php?edit=" . $row['RecommendationID'] . "'>Update</a> |
                <a href='delete_recommendation.php?id=" . $row['RecommendationID'] . "' onclick=\"return confirm('Delete this item?');\">Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>