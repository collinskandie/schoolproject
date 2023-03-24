<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    // Check if the user is already logged in
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        // header("location: ../../index.php");
        echo '<p>Successfull login</p>';
        echo '<a href="./controllers/auth/logout.php">Logout</a>';
        exit;
    } else {
        header("location: ../pages/login.php");
    }
    ?>
    <div>
    
    </div>

</body>

</html>