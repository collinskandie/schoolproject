</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Logout page</title>
    <!-- Link to CSS stylesheets and JavaScript files -->
    <link rel="stylesheet" href="../public/static/css/admin.css">
    <link rel="stylesheet" href="../public/static/css/index.css">
</head>

<body>
    <header>
        <!-- Your header content goes here -->
        <h1>Logout</h1>
        <div class="logo">
            <img src="../public/static/images/logo.png" alt="Logo">
        </div>

    </header>
    <div class="wrapper" style="text-align:center;">
        <br>
        <br>
        <br>
        <?php
        require_once("../models/dbcon.php");
        session_start();
        $action = "Logout";
        $actionby = $_SESSION['id'];
        $actionDate = date("Y-m-d");
        $actionTime = date("H:i:s");
        $category = "Authentication";
        $actionTable = "Users";
        $user_role = $_SESSION['role'];
        $users->logAction($action, $actionby, $actionDate, $actionTime, $category, $actionTable, $user_role);
        echo ("Logout page");
        session_destroy();
        // header('Location: index.php');

        ?>
        <p><a href="../public/pages/login.php">Login</a></p>
        <footer>
            <!-- Your footer content goes here -->
            <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
        </footer>
    </div>
</body>

</html>