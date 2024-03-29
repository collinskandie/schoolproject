<?php
$pagename = "Admin - Manage Fuels";
include('./adminmaster.php');
//fetch all inventoey
$result = $pumps->fetchAllItems();
$id = $_SESSION['id'];
$role = $_SESSION['role'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inventory_name =  $_POST['inventory_name'];
    $cost = $_POST['cost'];
    $quantity =  $_POST['quantity'];
    $price =  $_POST['price'];
    $fuel_type =  $_POST['fuel_type'];


    $action = "add inventory $inventory_name";
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $category = "inventory";
    $actionTable =  "inventory";
    $users->logAction($action, $id, $date, $time, $category, $actionTable, $role);

    $results = $pumps->addInventory($inventory_name, $cost, $price, $quantity, $id, $fuel_type);
    if ($results) {
        echo ("<script>alert('$inventory_name added successfully');</script>");
    } else {
        echo ("<script>alert('error');</script>");
    }
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
    <form action="" method="POST" onsubmit="return validateForm()">
        <div>
            <label for="name">Name</label>
            <input type="text" id="inventory_name" name="inventory_name">
        </div>
        <div>
            <label for="email">Cost</label>
            <input type="text" id="cost" name="cost">
        </div>
        <div>
            <label for="quantity">Quantity</label>
            <input type="text" id="quantity" name="quantity">
        </div>
        <div>
            <label for="price">Price</label>
            <input type="text" id="price" name="price">
        </div>
        <div>
            <label for="fuel_type">Fuel Type:</label>
            <select id="fuel_type" name="fuel_type">
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
                        <!-- <button onclick="window.location.href='./deleteinventory.php?id=<?= $row['id']; ?>'" class="button">Delete</button> -->
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
    <script>
        function validateForm() {
            var inventory_name = document.getElementById("inventory_name").value;
            var costInput = document.getElementById("cost").value;
            var quantityInput = document.getElementById("quantity").value;
            var priceInput = document.getElementById("price").value;
            var fuel_type = document.getElementById("fuel_type").value;
            if (inventory_name === "") {
                alert("Please enter fuel name.");
                return false;
            }
            if (costInput === "" || isNaN(parseFloat(costInput)) || parseFloat(costInput) <= 0) {
                alert("Fuel cost must be a positive number");
                return false;
            }

            if (quantityInput === "" || isNaN(parseFloat(quantityInput)) || parseFloat(quantityInput) <= 0) {
                alert("Quantity must be a positive number");
                return false;
            }
            if (priceInput === "" || isNaN(parseFloat(priceInput)) || parseFloat(priceInput) <= 0) {
                alert("Price must be a positive number");
                return false;
            }
            if (fuel_type === "") {
                alert("Fuel type cannot be blank");
                return false;
            }
            return true;
        }
    </script>
</main>