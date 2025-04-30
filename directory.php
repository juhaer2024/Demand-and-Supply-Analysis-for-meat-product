<?php
 include 'db.php';
 

 // Vendor Variables
 $edit_vendor_mode = false;
 $edit_vendor_id = "";
 $vendor_name = "";
 $vendor_address = "";
 $vendor_contact = "";
 $vendor_type = "";
 

 // Farm Variables
 $edit_farm_mode = false;
 $edit_farm_id = "";
 $farm_name = "";
 $farm_location = "";
 $farm_contact = "";
 $farm_size = "";
 

 // Handle Edit
 if (isset($_GET['edit'])) {
  $edit_id = $_GET['edit'];
 

  // Check if it's a Vendor ID
  $sql = "SELECT * FROM Vendor WHERE VendorID = '$edit_id'";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
  $edit_vendor_mode = true;
  $row = $result->fetch_assoc();
  $vendor_name = $row['VendorName'];
  $vendor_address = $row['VendorAddress'];
  $vendor_contact = $row['VendorContactInfo'];
  $vendor_type = $row['VendorType'];
  $edit_vendor_id = $edit_id;
  } else {
  // Check if it's a Farm ID
  $sql = "SELECT * FROM Farm WHERE FarmID = '$edit_id'";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
  $edit_farm_mode = true;
  $row = $result->fetch_assoc();
  $farm_name = $row['FarmName'];
  $farm_location = $row['FarmLocation'];
  $farm_contact = $row['FarmContactNo'];
  $farm_size = $row['FarmSize'];
  $edit_farm_id = $edit_id;
  }
  }
 }
 ?>
 

 <!DOCTYPE html>
 <html>
 <head>
  <title>Buyer/Seller & Farm Directory</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  .form-container {
  display: flex;
  justify-content: space-between;
  }
 

  .form-wrapper {
  width: 48%; /* Adjust as needed */
  }
 

  .table-container {
  display: flex;
  justify-content: space-between;
  }
 

  .table-wrapper {
  width: 48%; /* Adjust as needed */
  }
  </style>
 </head>
 <body>
  <h2>📒 Buyer/Seller & Farm Directory</h2>
 

  <div class="form-container">
  <div class="form-wrapper">
  <h3><?php echo $edit_vendor_mode ? 'Update Buyer/Seller' : 'Add Buyer/Seller'; ?></h3>
  <form method="POST" action="<?php echo $edit_vendor_mode ? 'update_directory.php' : 'insert_directory.php'; ?>">
  <input type="hidden" name="vendor_id" value="<?php echo $edit_vendor_id; ?>">
  <input type="hidden" name="form_type" value="vendor">
 

  <label>Buyer/Seller Name:</label>
  <input type="text" name="vendor_name" value="<?php echo $vendor_name; ?>" required>
 

  <label>Buyer/Seller Address:</label>
  <input type="text" name="vendor_address" value="<?php echo $vendor_address; ?>">
 

  <label>Buyer/Seller Contact Info:</label>
  <input type="text" name="vendor_contact" value="<?php echo $vendor_contact; ?>">
 

  <label>Buyer/Seller Type:</label>
  <input type="text" name="vendor_type" value="<?php echo $vendor_type; ?>" required>
 

  <button type="submit"><?php echo $edit_vendor_mode ? 'Update' : 'Add'; ?></button>
  </form>
  </div>
 

  <div class="form-wrapper">
  <h3><?php echo $edit_farm_mode ? 'Update Farm' : 'Add Farm'; ?></h3>
  <form method="POST" action="<?php echo $edit_farm_mode ? 'update_directory.php' : 'insert_directory.php'; ?>">
  <input type="hidden" name="farm_id" value="<?php echo $edit_farm_id; ?>">
  <input type="hidden" name="form_type" value="farm">
 

  <label>Farm Name:</label>
  <input type="text" name="farm_name" value="<?php echo $farm_name; ?>" required>
 

  <label>Farm Address:</label>
  <input type="text" name="farm_location" value="<?php echo $farm_location; ?>">
 

  <label>Farm Contact Info:</label>
  <input type="text" name="farm_contact" value="<?php echo $farm_contact; ?>">
 

  <label>Farm Size:</label>
  <input type="number" name="farm_size" value="<?php echo $farm_size; ?>">
 

  <button type="submit"><?php echo $edit_farm_mode ? 'Update' : 'Add'; ?></button>
  </form>
  </div>
  </div>
 

  <hr>
 

  <div class="table-container">
  <div class="table-wrapper">
  <h3>📋 Current Buyer/Seller List</h3>
  <table border="1" cellpadding="10">
  <tr>
  <th>Buyer/Seller Name</th>
  <th>Type</th>
  <th>Contact</th>
  <th>Address</th>
  <th>Actions</th>
  </tr>
 

  <?php
  $sql = "SELECT * FROM Vendor ORDER BY VendorID DESC";
  $result = $conn->query($sql);
 

  while ($row = $result->fetch_assoc()) {
  echo "<tr>
  <td>" . htmlspecialchars($row['VendorName']) . "</td>
  <td>" . htmlspecialchars($row['VendorType']) . "</td>
  <td>" . htmlspecialchars($row['VendorContactInfo']) . "</td>
  <td>" . htmlspecialchars($row['VendorAddress']) . "</td>
  <td>
  <a href='directory.php?edit=" . $row['VendorID'] . "'>Update</a> |
  <a href='delete_directory.php?id=" . $row['VendorID'] . "&type=vendor' onclick=\"return confirm('Delete this vendor?');\">Delete</a>
  </td>
  </tr>";
  }
  ?>
  </table>
  <div style="text-align: center; margin-top: 20px;">
  <a href="directory_charts.php" class="view-charts-btn">📊 View Vendor Type Chart</a>
  </div>
  </div>
 

  <div class="table-wrapper">
  <h3>📋 Current Farm List</h3>
  <table border="1" cellpadding="10">
  <tr>
  <th>Farm Name</th>
  <th>Size</th>
  <th>Contact</th>
  <th>Address</th>
  <th>Actions</th>
  </tr>
 

  <?php
  $sql = "SELECT * FROM Farm ORDER BY FarmID DESC";
  $result = $conn->query($sql);
 

  while ($row = $result->fetch_assoc()) {
  echo "<tr>
  <td>" . htmlspecialchars($row['FarmName']) . "</td>
  <td>" . htmlspecialchars($row['FarmSize']) . "</td>
  <td>" . htmlspecialchars($row['FarmContactNo']) . "</td>
  <td>" . htmlspecialchars($row['FarmLocation']) . "</td>
  <td>
  <a href='directory.php?edit=" . $row['FarmID'] . "'>Update</a> |
  <a href='delete_directory.php?id=" . $row['FarmID'] . "&type=farm' onclick=\"return confirm('Delete this farm?');\">Delete</a>
  </td>
  </tr>";
  }
  ?>
  </table>
  <div style="text-align: center; margin-top: 20px;">
  <a href="directory_charts_farm.php" class="view-charts-btn">📊 View Farm Chart</a>
  </div>
  </div>
  </div>
  </div>
 </body>
 </html>