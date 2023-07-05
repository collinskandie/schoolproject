<?php
$pagename = "Admin - Dashboard";
include('./adminmaster.php');
$id = $_GET['id'];
$result = $users->getUserById($id);
$username = $result['username'];

echo ("<script>alert('User $username will be deleted');</script>");

$results = $users->deleteUser($id);

if (!$results) {
    echo ("<script>alert('Error deleteing user');</script>");
} else {
    echo ("<script>alert('Successfully edited user $username');</script>");
}
