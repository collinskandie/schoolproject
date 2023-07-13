<?php
$pagename = "Admin - Manage Fuels";
include('./adminmaster.php');
//fetch all inventoey
$result = $pumps->fetchAllItems();
$id = $_SESSION['id'];
$role = $_SESSION['role'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $details = strtolower(trim($_POST['details']));
    $action = "add pump $details";
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $category = "pumps";
    $actionTable =  "pumps";
    $users->logAction($action, $id, $date, $time, $category, $actionTable, $role);
    $pumps->addPump($details);
}
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    thead {
        background-color: #f79974;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .button {
        border-radius: 10px;
        padding: 10px;
        background-color: #f79974;
        color: white;
        border: none;
        cursor: pointer;
    }

    form {
        max-width: 60%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
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
<main>
    <br>
    <form action="" method="POST">
        <div>
            <label for="username">Name</label>
            <input type="text" id="username" name="inventory_name" required>
        </div>
        <div>
            <label for="email">Cost</label>
            <input type="number" id="cost" name="cost" required>
        </div>
        <div>
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>
        <div>
            <label for="price">Price</label>
            <input type="number" id="price" name="price" required>
        </div>
        <div>
            <label for="fuel_type">Fuel Type:</label>
            <select id="fuel_type" name="fuel_type" required>
                <option value="">Select Fuel type</option>
                <?php
                $options = $pumps->fuelTypeslist();
                foreach ($options as $option) {
                ?>
                    <option value="<?= $option['id']; ?>"><?= $option['name']; ?></option>
                <?php
                } ?>

            </select>
        </div>
        <br>
        <button type="submit" class="button">Add</button>
    </form>
    <hr>
    <table>
        <thead>
            <!-- id, name, cost, price, quantity, last_sold, last_received, last_updated, updated_by, received_by, fuel_type -->
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Cost</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Last Recieved</th>
                <th>Recieved By</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["cost"] . "</td>
                    <td>" . $row["quantity"] . "</td>
                    <td>" . $row["price"] . "</td>
                    <td>" . $row["last_received"] . "</td>
                    <td>" . $row["username"] . "</td>                                      
                    ";
            ?>

                    <td>
                        <button onclick="window.location.href='./editinventoey.php?id=<?= $row['id']; ?>'" class="button">Edit</button>
                        <button onclick="window.location.href='./deleteinventory.php?id=<?= $row['id']; ?>'" class="button">Delete</button>
                    </td>

                    </tr>
            <?php
                }
            } else {
                echo "<tr>
                <td colspan='4'>No bookings found.</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</main>