<?php
// Include the database connection file
include '../../models/dbcon.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Hash the password 
    $password = password_hash($password, PASSWORD_DEFAULT);
    // Insert the user into the database
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $email, $role);
    $stmt->execute();

    // Redirect to the index page
    echo 'user added successfully';
    header('Location: ../../pages/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>   
    <link rel="stylesheet" href="../../res/css/register.css" />   
</head>

<body>
    <h1>Add User</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email">
        <br>
        <label for="role">Role:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="attendant">Attendant</option>
            <option value="manager">Manager</option>
            <option value="supervisor">Supervisor</option>
        </select>
        <br>
        <input type="submit" value="Add User">
    </form>
</body>

</html>