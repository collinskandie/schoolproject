<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kerarpon";
$charset = 'utf8mb4';
$newConn = "mysql:host=$servername;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($newConn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo '<h1 class="text-danger"> NO Database Found</h1>';
    throw new PDOException($e->getMessage());
}
require_once 'sales.php';
require_once 'users.php';
require_once 'reports.php';
require_once 'pumps.php';
$sales = new sales($pdo);
$pumps = new pumps($pdo);
$users = new users($pdo);
$reports = new reports($pdo);
// $users->insertUser("admin@gmail.com", "password");
