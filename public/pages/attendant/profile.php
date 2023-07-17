<?php
$title = "Dashboard - User Profile";
include('master.php');

require_once("../../../models/dbcon.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $password = md5($old_password . $email);
    $result = $users->userLogin($email, $password);
    if ($result) {
        $update_password = md5($new_password . $email);
        $results = $users->resetPassword($email, $update_password);

        if ($result) {
            echo ('<script>
            alert("Password Updated");
          </script>');
        } else {
            echo ('<script>
            alert("Error occurred");
          </script>');
        }
    } else {
        echo ('<script>
        alert("Error occurred");
      </script>');
    }
} ?>
<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .form-container {
        flex: 1;
        /* padding: 20px; */
        height: 100vh;
        margin-top: 100px;
    }

    .form-container h2 {
        margin-bottom: 20px;
    }

    .form-container input[type="text"],
    .form-container input[type="password"] {
        border-radius: 10px;
        width: 100%;
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

    .error {
        color: red;
    }
</style>
<div class="container">
    <div class="form-container">

        <h2>User Profile</h2>
        <p>Use this form to update your passwprd
        <p>
            <br>
            <br>
        <form action="" method="POST" onsubmit="return validateForm()">
            <div>
                <input type="text" id="email" name="email" value="<?= $userEmail ?>" readonly />
            </div>
            <div>
                <input type="text" id="username" name="username" value="<?= $name ?>" readonly />
            </div>
            <div>
                <input type="password" id="old_password" name="old_password" placeholder="Old Password" />
                <br>
                <span id="oldPasswordError" class="error"></span>
            </div>
            <div>
                <input type="password" id="new_password" name="new_password" placeholder="New Password" />
                <br>
                <span id="newPasswordError" class="error"></span>
            </div>
            <div>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" />
                <br>
                <span id="confirmPasswordError" class="error"></span>
            </div>
            <input type="submit" value="Change Password" />
            <br>
            <br>
        </form>
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
        var oldPassword = document.getElementById("old_password").value;
        var newPassword = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        if (oldPassword.trim() === "") {
            displayError("oldPassword", "Please enter your old password.");
            return false;
        } else {
            clearError("oldPassword");
        }

        if (newPassword.trim() === "") {
            displayError("newPassword", "Please enter your new password.");
            return false;
        } else {
            clearError("newPassword");
        }

        if (confirmPassword.trim() === "") {
            displayError("confirmPassword", "Please confirm your password.");
            return false;
        } else if (confirmPassword !== newPassword) {
            displayError("confirmPassword", "Passwords do not match.");
            return false;
        } else {
            clearError("confirmPassword");
        }

        return true;
    }
</script>