<?php
$pagename = "Admin - Create user";

include('adminmaster.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $name = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    // $new_password = md5($password . $email);
    $result = $users->insertUser($email, $password, $name, $phone, $role);
    if (!$result) {
        echo ("<script>alert('Error adding user');</script>");
    } else {
        echo ("<script>alert('Successfully added user');</script>");
        header('Location: user.php');
    }
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    form {
        max-width: 60%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #000;
        ;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    button:hover {
        background-color: grey;
    }

    .error {
        color: red;
    }
</style>

<br>
<form action="" method="POST" onsubmit="return validateForm()">
    <h2>Add User</h2>
    <div>
        <label for="username">Full Name</label>
        <input type="text" id="username" name="username">
        <span id="usernameError" class="error"></span>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <span id="emailError" class="error"></span>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone">
        <span id="phoneError" class="error"></span>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="passwordError" class="error"></span>
    </div>
    <div>
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="attendant">Attendant</option>
        </select>
        <span id="roleError" class="error"></span>
    </div>
    <br>
    <button type="submit" class="button">Add User</button>
</form>

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
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;
        var password = document.getElementById("password").value;
        var role = document.getElementById("role").value;

        if (username.trim() === "") {
            displayError("username", "Please enter your full name.");
            return false;
        } else {
            clearError("username");
        }

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

        if (phone.trim() === "") {
            displayError("phone", "Please enter your phone number.");
            return false;
        } else {
            clearError("phone");
        }

        if (password.trim() === "") {
            displayError("password", "Please enter a password.");
            return false;
        } else if (password.length < 8 || !/\d/.test(password) || !/[A-Z]/.test(password) || !/[!@#$%^&*]/.test(password)) {
            displayError("password", "Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special symbol.");
            return false;
        } else {
            clearError("password");
        }

        if (role === "") {
            displayError("role", "Please select a role.");
            return false;
        } else {
            clearError("role");
        }

        return true;
    }
</script>