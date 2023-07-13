<?php
$pagename = "Admin - Dashboard";
include('./adminmaster.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email']));
    $name = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $result = $users->updateUser($email, $name, $phone, $role);
    if (!$result) {
        echo ("<script>alert('Error Editing user');</script>");
    } else {
        echo ("<script>alert('Successfully edited user $name');</script>");
    }
}
$id = $_GET['id'];
$result = $users->getUserById($id);
?>
<style>
    form {
        max-width: 60%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        border-radius: 10px;
        padding: 10px;
        background-color: #f79974;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: grey;
    }
</style>
<?php

?>


<form action="" method="POST">
    <div>
        <label for="username">Full Name</label>
        <input type="text" id="username" name="username" value="<?= $result['username']; ?>">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $result['email']; ?>" readonly>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?= $result['phone']; ?>">
    </div>

    <div>
        <label for="role">Role:</label>
        <select id="role" name="role" value="<?= $result['role']; ?>">
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="attendant">Attendant</option>
        </select>
    </div>
    <br>
    <br>
    <button type="submit">Edit</button>
</form>