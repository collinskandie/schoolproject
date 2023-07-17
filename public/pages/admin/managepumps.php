<?php
$pagename = "Admin - Manage Pumps";
include('./adminmaster.php');
$result = $pumps->allPumps();
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
    <form action="" method="POST" onsubmit="return validateForm()">
        <div>
            <label for="details">Pump Details</label>
            <input type="text" id="details" name="details">
        </div>
        <br>
        <button type="submit" class="button">Save</button>
    </form>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Pump Id</th>
                <th>Details</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["pump_details"] . "</td>                   
                    ";
            ?>

                    <td>
                        <button onclick="window.location.href='./pumpedit.php?id=<?= $row['id']; ?>'" class="button">Edit</button>
                        <button onclick="window.location.href='./pumpdelete.php?id=<?= $row['id']; ?>'" class="button">Delete</button>
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
            var detailsInput = document.getElementById("details").value;

            if (detailsInput === "") {
                alert("Please enter the pump details.");
                return false;
            }
            return true;
        }
    </script>
</main>