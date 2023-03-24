<?php 
include("../../models/dbcon.php");
$password = 'collins'; // Replace with the actual password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password; // Output the hashed password

?>