<?php
$pagename = "Admin - Delete Inventory";
include('./adminmaster.php');

$id = $_GET['id'];
$result = $pumps->getInventory($id);
$name = $result['name'];

echo ("<script>alert('$name will be deleted');</script>");

$results = $pumps->deleteInventory($id);

if (!$results) {
    echo ("<script>alert('Error deleteing $name');</script>");
} else {
    echo ("<script>alert('Successfully deleted $name');</script>");
    // header("Location: managepumps.php");
}
