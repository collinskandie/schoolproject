<?php
$title = "Payment";
include('master.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pump = $_POST['pump']; //pumpid
    $user = $_SESSION['id']; //sales person id

    $fueltype = $_POST['fuelid']; //$item_id
    $fuel = $_POST['name']; //$item_id
    $quantity = $_POST['quantity']; //item_quantity
    $price = $_POST['price']; //price

    $total = $_POST['total']; //total
    $tendered = $_POST['tendered'];
    $payment = $_POST['payment-method'];
    $change = $_POST['change'];
    //
    // log variables
    $action = "Sale of $fuel";
    // $actionby = $result['id']; //user 
    $actionDate = date("Y-m-d"); //date sold
    $actionTime = date("H:i:s");
    $category = "Make a sale";
    $actionTable = "Sales";
    $user_role = $result['role'];
    $users->logAction($action, $user, $actionDate, $actionTime, $category, $actionTable, $user_role);
    $result = $sales->makeSale($fueltype, $quantity, $price, $total, $pump, $user, $actionTime, $actionDate);

    if ($result) {
        $receipt = $result;
        $success = $sales->savePayment($receipt, $payment, $tendered, $change);
        if ($success) {
            echo ("Sale successfull");
        }
    }
}
