<?php
 include 'db.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $form_type = $_POST['form_type'];

 if ($form_type == "vendor") {
 $vendor_id = $_POST['vendor_id'];
 $vendor_name = $_POST['vendor_name'];
 $vendor_address = $_POST['vendor_address'];
 $vendor_contact = $_POST['vendor_contact'];
 $vendor_type = $_POST['vendor_type'];

 $sql = "UPDATE Vendor SET 
 VendorName='$vendor_name', 
 VendorAddress='$vendor_address', 
 VendorContactInfo='$vendor_contact', 
 VendorType='$vendor_type' 
 WHERE VendorID='$vendor_id'";

 if ($conn->query($sql) === TRUE) {
 header("Location: directory.php");
 exit();
 } else {
 echo "Error: " . $sql . "<br>" . $conn->error;
 }
 } elseif ($form_type == "farm") {
 $farm_id = $_POST['farm_id'];
 $farm_name = $_POST['farm_name'];
 $farm_location = $_POST['farm_location'];
 $farm_contact = $_POST['farm_contact'];
 $farm_size = $_POST['farm_size'];

 $sql = "UPDATE Farm SET 
 FarmName='$farm_name', 
 FarmLocation='$farm_location', 
 FarmContactNo='$farm_contact', 
 FarmSize='$farm_size' 
 WHERE FarmID='$farm_id'";

 if ($conn->query($sql) === TRUE) {
 header("Location: directory.php");
 exit();
 } else {
 echo "Error: " . $sql . "<br>" . $conn->error;
 }
 } else {
 echo "Error: Invalid form type.";
 }

 $conn->close();
 }
 ?>