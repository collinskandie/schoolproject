<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../static/css/login.css">
</head>

<body>
    <?php
    require_once("../../models/dbcon.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $new_password = md5($password . $email);
        $result = $users->userLogin($email, $new_password);

        if (!$result) {
            echo '<script>alert("Incorrect password or email")</script>';
        } else {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $result['id'];
            $_SESSION['role'] = $result['role'];

            if ($result['role'] == 'admin') {
                header("Location: ./admin/index.php");
            } elseif ($result['role'] == 'web_user') {
                header("Location: ./attendant/index.php");
            }
        }
    }
    ?>
    <div class="container">
        <div class="logo">
            <img src="../static/images/logo.png" alt="Logo">
        </div>
        <form class="login-form" action="login.php" method="POST">
            <h1>Login</h1>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>