<?php
 include 'db.php';

 if (isset($_GET['id']) && isset($_GET['type'])) {
 $id = $_GET['id'];
 $type = $_GET['type'];

 if ($type == "vendor") {
 $sql = "DELETE FROM Vendor WHERE VendorID='$id'";
 } elseif ($type == "farm") {
 $sql = "DELETE FROM Farm WHERE FarmID='$id'";
 } else {
 echo "Error: Invalid entity type.";
 exit();
 }

 if ($conn->query($sql) === TRUE) {
 header("Location: directory.php");
 exit();
 } else {
 echo "Error: " . $sql . "<br>" . $conn->error;
 }

 $conn->close();
 } else {
 echo "Error: Missing ID or type.";
 }
 ?>