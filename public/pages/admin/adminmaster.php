<?php
session_start();

if (!$_SESSION['id']) {
    //you must be logged in    
    header("Location: ../login.php?error_message=" . urlencode("Youmust be logged in"));
    if (!$_SESSION['role'] == 'admin') {
        header("Location: ../attendant/index.php?error_message=" . urlencode("You are not authorized to view this page"));
    }
}
$userID = $_SESSION['id'];
$userEmail = $_SESSION['email'];


?>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../static/css/admin.css">
    <link rel="stylesheet" href="../../static/css/index.css">
    <style>
        .sidenav {
            margin-top: 110px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #ebe0d1;
            padding-top: 20px;
            height: 100%;
            top: 0;
            left: 0;
            width: 250px;
            padding: 20px;
            overflow-y: auto;
        }

        .sidenav a {
            display: block;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
        }

        .sidenav a:hover {
            background-color: #111;
        }

        .content {
            margin-top: auto;
            margin-left: 250px;
            padding: 16px;
            background-color: #f1f1f1;
        }

        .but-menu {
            border-radius: 10px;
            padding: 10px;
            background-color: #f79974;
            color: black;
            border: 1px solid white;
            cursor: pointer;
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    require_once("../../../models/dbcon.php");
    //find user details
    $result = $users->getUserByEmail($userEmail);
    $name = $result['username'];
    ?>
    <header>
        <!-- Your header content goes here -->
        <h1><?= $pagename ?></h1>
        <div class="logo">
            <img src="../../static/images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="user.php">Users</a></li>
                <li><a href="./purchaseorders.php">Purchase Orders</a></li>
                <li><a href="./reportSales.php">Reports</a></li>
                <!-- <li><a href="#">Settings</a></li> -->
                <li><a href="../../../controllers/logout.php">Logout</a></li>
            </ul>
        </nav>

    </header>
    <div class="sidenav">
        <a class="but-menu" href="index.php">Dashboard</a>
        <a class="but-menu" href="recieve.php">Receive</a>
        <a class="but-menu" href="managepumps.php">Manage Pumps</a>
        <a class="but-menu" href="managefuels.php">Manage Fuel</a>
        <a class="but-menu" href="stocktake.php">Stock Take</a>
        <a class="but-menu" href="analytics.php">Analytics</a> <!-- anaalytics with graphs -->
        <a class="but-menu" href="reports.php">Reports</a> 
        <!-- <a class="but-menu" href="analytics.php">Analytics</a>  -->
        <a class="but-menu" href="logs.php">User Logs</a>
    </div>

    <div class="content">
        <div class="wrapper">
            <!-- //page content here  -->
            <footer>
                <!-- Your footer content goes here -->
                <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
            </footer>
</body>

</html>