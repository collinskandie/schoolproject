<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
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

        .error {
            color: red;
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
        $result = $users->getUserByEmail($email);
        if (!$result) {
            echo ('<script>
            alert("user does not exhist");
          </script>');
        } else {
    ?>
            <div class="container">
                <div class="form-container">
                    <div class="logo">
                        <img src="../../public/static/images/logo.png" alt="Logo" />
                    </div>
                    <h2>Recover Account</h2>
                    <form action="savepassword.php" method="POST" onsubmit="return validateNewForm()">
                        <div>
                            <input type="text" id="email" name="email" value="<?= $result['email']; ?>" placeholder="Email" readonly />
                        </div>
                        <div>
                            <input type="password" id="otp" name="otp" placeholder="OTP" readonly>
                            <!-- <span id="passwordError" class="error"></span> -->
                        </div>
                        <div>
                            <input type="password" id="password" name="password" placeholder="New Password">
                            <br>
                            <span id="passwordError" class="error"></span>
                        </div>
                        <div>
                            <input type="password" id="new_password" name="new_password" placeholder="Confirm Password">
                            <br>
                            <span id="passwordError" class="error"></span>
                        </div>
                        <input type="submit" value="Submit" />
                        <br>
                        <br>
                        <a href="./login.php" style="text-decoration: none;">Login</a>
                    </form>
                </div>
                <div class="image-container">
                </div>
            </div>
            <script>
                function displayError(inputId, errorMessage) {
                    var errorElement = document.getElementById(inputId + "Error");
                    errorElement.textContent = errorMessage;
                }

                function clearError(inputId) {
                    var errorElement = document.getElementById(inputId + "Error");
                    errorElement.textContent = "";
                }

                function validateNewForm() {
                    var password = document.getElementById("password").value;
                    var confirmPassword = document.getElementById("new_password").value;

                    if (password.trim() === "") {
                        displayError("password", "Please enter a password.");
                        return false;
                    } else {
                        clearError("password");
                    }

                    if (confirmPassword.trim() === "") {
                        displayError("confirmPassword", "Please confirm your password.");
                        return false;
                    } else if (confirmPassword !== password) {
                        displayError("confirmPassword", "Passwords do not match.");
                        return false;
                    } else {
                        clearError("confirmPassword");
                    }

                    return true;
                }
            </script>
    <?php

        }
    } ?>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <img src="../../public/static/images/logo.png" alt="Logo" />
            </div>
            <h2>Recover Account</h2>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div>
                    <input type="text" id="email" name="email" placeholder="Email" />
                    <br>
                    <span id="emailError" class="error"></span>
                </div>

                <input type="submit" value="Confirm Email" />
                <br>
                <br>
                <a href="./login.php">Login</a>
            </form>
        </div>
        <div class="image-container">
        </div>
    </div>
    <script>
        function displayError(inputId, errorMessage) {
            var errorElement = document.getElementById(inputId + "Error");
            errorElement.textContent = errorMessage;
        }

        function clearError(inputId) {
            var errorElement = document.getElementById(inputId + "Error");
            errorElement.textContent = "";
        }

        function validateForm() {
            var email = document.getElementById("email").value;
            var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (email.trim() === "") {
                displayError("email", "Please enter your email address.");
                return false;
            } else if (!emailRegex.test(email)) {
                displayError("email", "Please enter a valid email address.");
                return false;
            } else {
                clearError("email");
            }
            return true;
        }
    </script>
</body>

</html>