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
        session_start();
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