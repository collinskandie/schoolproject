<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
        }
        .form-container {
            flex: 1;
            padding: 20px;
            height: 100vh;
            margin-left: 50px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            border-radius: 10px;
            width: 60%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .form-container input[type="submit"] {
            border-radius: 10px;
            width: 64%;
            padding: 10px;
            background-color: #f79974;
            color: white;
            border: none;
            cursor: pointer;
        }
        .image-container {
            flex: 1.5;
            height: 100%;
            background-image: url("../../public/static/images/loginimage.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .logo {
            margin-top: 100px;
            margin-bottom: 100px;
            margin-left: 100px;
        }
        .logo img {
            max-height: 300px;
            object-fit: contain;
        }
        @media only screen and (max-width: 600px) {
            .container {
                flex-direction: row;
            }
            .form-container {
                margin-bottom: 20px;
            }
            .image-container {
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['id'])) {
        echo ('404 error! You have an exhisting session my guy!');
        if ($_SESSION['role'] == "admin") {

            header('Location: ./admin/index.php');
        } else {
            header('Location: ./attendant/index.php');
        }
        exit();
    }
    require_once("../../models/dbcon.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $new_password = md5($password . $email);
        $result = $users->userLogin($email, $new_password);
        if (!$result) {
            echo ('<script>
            alert("Incorrect password or email");
          </script>');
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $result['id'];
            $_SESSION['role'] = $result['role'];
            if (
                $result['role'] ==
                'admin'
            ) {
                echo ('<script>
                alert("Login success,Welcome to admin page");
              </script>');
                header("Location: ./admin/index.php");
            } elseif (
                $result['role']
                == 'attendant'
            ) {
                echo ('<script>
                alert("Login success,Welcome");
              </script>');
                header("Location: ./attendant/index.php");
            }
            $action = "Login";
            $actionby = $result['id'];
            $actionDate = date("Y-m-d");
            $actionTime = date("H:i:s");
            $category = "Authentication";
            
            $actionTable = "Users";
            $user_role = $result['role'];
            $users->logAction($action, $actionby, $actionDate, $actionTime, $category, $actionTable, $user_role);
        }
    } ?>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <img src="../../public/static/images/logo.png" alt="Logo" />
            </div>
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <input type="text" id="email" name="email" placeholder="Email" required />
                <input type="password" id="password" name="password" placeholder="Password" required />
                <input type="submit" value="Login" />
            </form>
        </div>
        <div class="image-container">
        </div>
    </div>
</body>

</html>