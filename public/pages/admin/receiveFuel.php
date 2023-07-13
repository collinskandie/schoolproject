<?php
$pagename = "Admin - Success Page";
include('./adminmaster.php');
$supplier = $_POST['supplier'];
$vehicleType = $_POST['vehicle-type'];
$driverName = $_POST['driver-name'];
$items = $_POST['item'];
$quantities = $_POST['quantity'];
$costs = $_POST['cost'];
$subtotals = $_POST['sub-total'];
$user = $_SESSION['id'];
$user_role = $_SESSION['role'];
$date = date('Y-m-d');
$time = date('H:i:s');

$result = $purchase->saveOrder($supplier, $vehicleType, $driverName, $items, $quantities, $costs, $subtotals, $user);
$users->logAction("Create PO", $user, $date, $time, "PO", "Inventory,Tanks,Logs", $user_role);

if ($result) {
    $poNumber = $result;

    $getItems = $purchase->getItems($poNumber);

?>


    <style>
        .invoice-container {
            width: 100%;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #333;
        }

        #items-received {
            margin-bottom: 20px;
        }

        #invoice-number {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
    <div class="invoice-container">
        <h1>Purchase Order: <?= $poNumber ?></h1>
        <div id="items-received"></div>
        <div id="invoice-number"></div>
    </div>
    <?php
    // Assuming you have a form that submits the item details and purchase order information

    // Process the form submission and retrieve the item details and purchase order information
    // $itemsReceived = $_POST['itemsReceived'];
    // $invoiceNumber = $_POST['invoiceNumber'];

    // Output the item details and invoice number
    echo "<p>Items Received:</p>";
    echo "<ul>";
    foreach ($getItems as $item) {
    ?>
        <P><?= $item['name']; ?></P>
    <?php
    }
    echo "</ul>";
    // echo "<p>Invoice Number: $poNumber</p>";
    ?>
    <br>
    <a href="./recieve.php" class="button">Go back</a>


    <script src="script.js"></script>

<?php
} else {
    echo ("<script>alert(Error occured)</script>");
}
