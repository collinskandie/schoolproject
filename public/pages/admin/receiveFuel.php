<?php
$pagename = "Admin - Query";
include('./adminmaster.php');
$supplier = $_POST['supplier'];
$vehicleType = $_POST['vehicle-type'];
$driverName = $_POST['driver-name'];
$items = $_POST['item'];
$quantities = $_POST['quantity'];
$costs = $_POST['cost'];
$subtotals = $_POST['sub-total'];
$user = $_SESSION['id'];

$result = $purchase->saveOrder($supplier, $vehicleType, $driverName, $items, $quantities, $costs, $subtotals, $user);

if ($result) {
    echo ("<script>alert(order saved)</script>");
} else {
    echo ("<script>alert(Error occured)</script>");
}
