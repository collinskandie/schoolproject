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
</style>
<?php

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
<br>
<form action="" method="POST">
    <h2>Add User</h2>
    <div>
        <label for="username">Full Name</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="attendant">Attendant</option>
        </select>
    </div>
    <button type="submit">Add User</button>
</form>