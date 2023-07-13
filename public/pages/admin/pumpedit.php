<?php
$pagename = "Admin - Dashboard";
include('./adminmaster.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $details = $_POST['details'];
    $id = $_POST['id'];

    $action = "edit pump $details";
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $category = "pumps";
    $actionTable =  "pumps";
    $user = $_SESSION['id'];
    $role = $_SESSION['role'];

    $users->logAction($action, $user, $date, $time, $category, $actionTable, $role);

    $pumps->editPump($id, $details);
}
$id = $_GET['id'];
$result = $pumps->getPumpbyId($id);
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
        <label for="username">Pump ID</label>
        <input type="text" id="details" name="id" value="<?= $result['id']; ?>" readonly>
    </div>
    <div>
        <label for="email">Pump Details:</label>
        <input type="text" id="details" name="details" value="<?= $result['pump_details']; ?>">
    </div>
    <div>
        <label for="phone">Update at</label>
        <input type="text" id="phone" name="phone" value="<?= $result['updated_at']; ?>" readonly>
    </div>
    <br>
    <br>
    <button type="submit" class="button">Submit</button>
</form>