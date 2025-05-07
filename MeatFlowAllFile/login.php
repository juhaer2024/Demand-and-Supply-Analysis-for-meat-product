<?php
	include("db.php");
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div id="form">
        <form name="form" action="loginlogic.php" method="POST">
            <label>User Name</label>
            <div>
            <input type="text" name="username" id="user">
            </div>
            <br>
            <br>
            <label>Password</label>
            <div>
            <input type="password" name="password" id="pass">
            </div>
            <br>
            <br>
            <div>
            <input type="submit" id="btn" name="submit" value="Login">
            </div>
            
        </form>
    </div>


    

</body>

</html>
