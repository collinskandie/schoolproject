<?php
$pagename = "Admin - Edit Inventory";
include('./adminmaster.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    //logs data
    $id = $_POST['id'];
    $action = "edit inventory $name";
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $category = "inventory";
    $actionTable =  "inventory";
    $user = $_SESSION['id'];
    $role = $_SESSION['role'];

    $users->logAction($action, $user, $date, $time, $category, $actionTable, $role);

    $pumps->editPump($id, $details);
}
$id = $_GET['id'];
$result = $pumps->getInventory($id);
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

    button:hover {
        background-color: grey;
    }
</style>
<?php

?>


<form action="" method="POST">
    <div>
        <label for="id">ID</label>
        <input type="text" id="details" name="id" value="<?= $result['id']; ?>" readonly>
    </div>
    <!-- id, name, cost, price, quantity, last_sold, last_received, last_updated, updated_by, received_by, fuel_type -->
    <div>
        <label for="email">Description</label>
        <input type="text" id="name" name="name" value="<?= $result['name']; ?>">
    </div>
    <div>
        <label for="email">Cost</label>
        <input type="text" id="cost" name="cost" value="<?= $result['cost']; ?>">
    </div>
    <div>
        <label for="email">Price</label>
        <input type="text" id="price" name="price" value="<?= $result['price']; ?>">
    </div>
    <div>
        <label for="email">Quantity</label>
        <input type="text" id="price" name="price" value="<?= $result['quantity']; ?>">
    </div>
    <div>
        <label for="phone">Update at</label>
        <input type="text" id="phone" name="phone" value="<?= $result['last_received']; ?>" readonly>
    </div>
    <br>
    <br>
    <button type="submit" class="button">Submit</button>
</form>