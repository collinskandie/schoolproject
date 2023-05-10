<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kerarapon";
$charset = 'utf8mb4';
$newConn = "mysql:host=$localhost;dbname=$kerarapon;charset=$charset";

try {
    $pdo = new PDO($newConn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
} catch (PDOException $e) {
    echo '<h1 class="text-danger"> NO Database Found</h1>';
    throw new PDOException($e->getMessage());
}
require_once 'crud.php';
require_once 'user.php';
require_once 'reports.php';
$crud = new sales($pdo);
$users = new users($pdo);
$reports = new reports($pdo);
$users->insertUser("admin@gmail.com", "password");
