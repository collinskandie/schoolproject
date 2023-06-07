</html>
<!DOCTYPE html>
<html>
<?php

session_start();
$userEmail = $_SESSION['email'];
$userID = $_SESSION['id'];
require_once("../../../models/dbcon.php");
//find user details
$result = $users->getUserByEmail($userEmail);
$name = $result['username'];
?>


<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <!-- Link to CSS stylesheets and JavaScript files -->
    <link rel="stylesheet" href="../../static/css/admin.css">
    <link rel="stylesheet" href="../../static/css/index.css">
</head>

<body>
    <header>
        <!-- Your header content goes here -->
        <h1>Dashboard</h1>
        <div class="logo">
            <img src="../../static/images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li>Welcome <?= $name ?></a></li>
                <li><a href="index.php">Sale</a></li>
                <li><a href="cashout.php">Cashout</a></li>
                <li><a href="../../../controllers/logout.php">Logout</a></li>

            </ul>
        </nav>
    </header>

    <div class="wrapper">
        <!-- //page content here  -->
        <footer>
            <!-- Your footer content goes here -->
            <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
        </footer>
</body>

</html>