</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Link to CSS stylesheets and JavaScript files -->
    <link rel="stylesheet" href="../../static/css/admin.css">
    <link rel="stylesheet" href="../../static/css/index.css">
</head>

<body>
    <?php
    session_start();
    $userEmail = $_SESSION['email'];
    $userID = $_SESSION['id'];
    require_once("../../../models/dbcon.php");
    //find user details
    $result = $users->getUserByEmail($userEmail);
    $name = $result['username'];
    ?>
    <header>
        <!-- Your header content goes here -->
        <h1>Admin Dashboard</h1>
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

    <div class="wrapper">
        <!-- //page content here  -->
        <footer>
            <!-- Your footer content goes here -->
            <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
        </footer>
</body>

</html>