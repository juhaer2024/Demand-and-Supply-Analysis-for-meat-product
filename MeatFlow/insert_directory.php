<?php
 include 'db.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $form_type = $_POST['form_type'];

 if ($form_type == "vendor") {
 $vendor_name = $_POST['vendor_name'];
 $vendor_address = $_POST['vendor_address'];
 $vendor_contact = $_POST['vendor_contact'];
 $vendor_type = $_POST['vendor_type'];

 $sql = "INSERT INTO Vendor (VendorName, VendorAddress, VendorContactInfo, VendorType) VALUES 
 ('$vendor_name', '$vendor_address', '$vendor_contact', '$vendor_type')";

 if ($conn->query($sql) === TRUE) {
 header("Location: directory.php"); // Redirect to the main page
 exit();
 } else {
 echo "Error: " . $sql . "<br>" . $conn->error;
 }
 } elseif ($form_type == "farm") {
 $farm_name = $_POST['farm_name'];
 $farm_location = $_POST['farm_location'];
 $farm_contact = $_POST['farm_contact'];
 $farm_size = $_POST['farm_size'];

 $sql = "INSERT INTO Farm (FarmName, FarmLocation, FarmContactNo, FarmSize) VALUES 
 ('$farm_name', '$farm_location', '$farm_contact', '$farm_size')";

 if ($conn->query($sql) === TRUE) {
 header("Location: directory.php"); // Redirect to the main page
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