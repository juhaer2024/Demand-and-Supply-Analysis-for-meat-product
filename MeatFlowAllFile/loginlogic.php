<?php
include("db.php");

// Check if form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Helpful for debugging
    }

    $count = mysqli_num_rows($result);

    if ($count == 1) {
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "<script>
            alert('Login Failed! Invalid username or password');
            window.location.href = 'home.php';
        </script>";
    }
}
