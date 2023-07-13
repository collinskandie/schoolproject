<?php
$title = "Cashout";
include('master.php');
$user = $_SESSION['id'];

$message = isset($_GET['message']) ? $_GET['message'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clearedValue = $_POST['clearedValue'];
    $cleared_time = date('H:i:s');
    $tenderAmount = $_POST['tenderAmount'];
    $variance = $_POST['variance'];
    $selectedReceiptIds = $_POST['selected'] ?? [];
    $receiptIdsString = implode(',', $selectedReceiptIds);
    //clear

    $result = $sales->clearSale($receiptIdsString, $cleared_time, $clearedValue, $tenderAmount, $variance, $user);
    $result2 = $sales->ClearEntry($selectedReceiptIds);

    // echo ("script> alert('record updated, $result2.toString()');</script>");

    //update log table
    $action = "Clear sale";
    $actionDate = date('Y-m-d');
    $category = "sales $receiptIdsString";
    $actionTable = "sales_clearance";
    $user_role = $_SESSION['role'];

    $users->logAction($action, $user, $actionDate, $cleared_time, $category, $actionTable, $user_role);
}
?>
<style>
    h1 {
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    table th {
        background-color: #f2f2f2;
    }

    tfoot td {
        font-weight: bold;
    }

    #total-price {
        font-size: 18px;
        color: red;
    }


    .container {
        flex-direction: column;
        /* position: fixed; */
        width: 100%;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 20px;
        height: 100vh;
        /* height: 100vh; */
    }

    #record-table {
        /* margin-top: 20px; */
        margin: 20px;

    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
    }

    .form-group input[type="number"],
    .form-group input[type="text"] {
        border-radius: 10px;
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
    }

    .button {
        border-radius: 10px;
        width: 64%;
        padding: 10px;
        background-color: #f79974;
        color: white;
        border: none;
        cursor: pointer;
    }

    .card-container {
        display: flex;
        flex-direction: row;
    }

    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 300px;
        padding: 20px;
        margin: 10px;
        margin-right: 100px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .card-warning {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 300px;
        padding: 20px;
        margin: 10px;
        margin-right: 100px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
<div class="container">
    <br>
    <br>
    <br>
    <?php if (!empty($message)) : ?>

        <div class="message-popup">
            <script>
                window.onload = function() {
                    alert('<?= $message; ?>');
                };
            </script>
        </div>
    <?php endif; ?>



    <?php
    echo $message;
    $result = $sales->unCleared($user);
    if (!$result) {
        $date = date('Y-m-d');
        $userSales = $sales->salesperPerson($user, $date);
        $sales_total = 0.0;
        $litres_total = 0.0;
        if ($userSales) {
            foreach ($userSales as $row) {
                $sales_total += floatval($row['total']);
                $litres_total += $row['item_quantity'];
            }
        }
    ?>
        <div class="card-container">
            <div class="card" style="text-align: center;">
                Todays Sales
                <br>
                <strong> <?= $sales_total ?> </strong>
            </div>
            <div class="card" style="text-align: center;">
                Total litres sold
                <br>
                <strong> <?= $litres_total ?> </strong>
            </div>
            <br>
        </div>
        <div class="card-warning" style="width:100%; margin-top:100px">
            <p>No sales to clear</p>
            <button class="button" onclick="window.location.href = 'make-sale.php'">Make a sale</button>
        </div>

    <?php
    } else {


    ?>
        <form action="cash-out.php" method="POST">
            <table id="records-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Receipt Number</th>
                        <th>Payment Method</th>
                        <th>Receipt Total</th>
                        <th>Status</th>
                        <th>Clear</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    $total = 0;
                    $cash = 0;
                    $mpesa = 0;
                    $pdq = 0;

                    foreach ($result as $row) {
                        $total += $row['total'];
                        if ($row['payment_method'] == 'cash') {
                            $cash += $row['total'];
                        }
                        if ($row['payment_method'] == 'mpesa') {
                            $mpesa += $row['total'];
                        }
                        if ($row['payment_method'] == 'pdq') {
                            $mpesa += $row['total'];
                        }
                    ?>
                        <tr>
                            <td><?= $row['pid'] ?></td>
                            <td><?= $row['receipt_number'] ?></td>
                            <td><?= $row['payment_method'] ?></td>
                            <td class="amount"><?= $row['total'] ?></td>
                            <td><?= $row['cleared'] ?></td>
                            <td>
                                <input type="checkbox" id="selectCheckbox" name="selected[]" value="<?= $row['receipt_number'] ?>">
                            </td>
                        </tr>
                    <?php
                    } ?>

                <tfoot>
                    <tr>
                        <td>Total:</td>
                        <td id="total-amount-tendered" colspan="5"> <strong><?= $total; ?></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <br>
            <div class="card-container">
                <div class="card" style="text-align: center;">
                    Expected cash: <?= $cash ?>
                    <br>
                    Expected Mpesa: <?= $mpesa ?>
                    <br>
                    Expected PDQ: <?= $pdq ?>
                </div>

                <br>
                <div class="card" style="text-align: center;">
                    To be cleared
                    <div class="form-group">
                        <input type="number" id="totalInput" name="clearedValue" readonly>
                    </div>
                </div>
                <br>
                <div class="card" style="text-align: center;">
                    <div class="form">
                        <div class="form-group">
                            <label>Cash Counted:</label>
                            <input type="number" name="cash" onchange="calculateTotal()">
                            <label>Mpesa:</label>
                            <input type="number" name="mpesa" onchange="calculateTotal()">
                            <label>PDQ:</label>
                            <input type="number" name="pdq" onchange="calculateTotal()">
                        </div>
                        <br>

                    </div>
                    <br>
                </div>
                <div class="card" style="text-align: center;">
                    <label>Total:</label>
                    <div class="form-group">
                        <div id="tenderedDiv"></div>
                        <input type="number" id="tenderedDiv" name="tenderAmount" readonly>
                    </div>
                </div>
            </div>
            <div class="card-warning" style="width:100%; margin-top:100px">
                <div class="form-group">
                    <label>Variance:</label>
                    <input type="number" id="varianceDiv" name="variance" readonly>

                    <br>
                    <button type="submit" class="button">Reconcile</button>
                </div>
            </div>
        </form>

    <?php
    } ?>
</div>


<script>
    let selectedTotal = 0;
    document.addEventListener("DOMContentLoaded", function() {
        const priceCells = document.getElementsByClassName("price");
        let totalPrice = 0;

        for (let i = 0; i < priceCells.length; i++) {
            const price = parseFloat(priceCells[i].textContent);
            totalPrice += price;
        }
        document.getElementById("total-price").textContent = totalPrice.toFixed(2);

    });
    document.addEventListener("DOMContentLoaded", function() {
        const selectCheckboxes = document.getElementsByName("selected[]");
        let amountCells = document.getElementsByClassName("amount");
        let totalDiv = document.getElementById("totalDiv");
        let totalInput = document.getElementById("totalInput");

        // Calculate and display the initial total
        let total = 0;
        for (let i = 0; i < amountCells.length; i++) {
            const amount = parseFloat(amountCells[i].textContent);
            total += amount;
        }
        // totalDiv.textContent = 'Total: ' + total.toFixed(2);

        // Handle checkbox change events
        for (let i = 0; i < selectCheckboxes.length; i++) {
            selectCheckboxes[i].addEventListener("change", function() {
                selectedTotal = 0;

                for (let j = 0; j < selectCheckboxes.length; j++) {
                    if (selectCheckboxes[j].checked) {
                        const amount = parseFloat(amountCells[j].textContent);
                        selectedTotal += amount;
                    }
                }

                totalDiv.textContent = 'Total: ' + selectedTotal.toFixed(2);
                totalInput.value = selectedTotal.toFixed(2);
            });
        }
    });

    function calculateTotal() {
        const cashInput = document.getElementsByName("cash")[0];
        const mpesaInput = document.getElementsByName("mpesa")[0];
        const pdqInput = document.getElementsByName("pdq")[0];
        const tenderedDiv = document.getElementById("tenderedDiv");
        const varianceDiv = document.getElementById("varianceDiv");

        const cash = parseFloat(cashInput.value) || 0;
        const mpesa = parseFloat(mpesaInput.value) || 0;
        const pdq = parseFloat(pdqInput.value) || 0;

        const ctotal = cash + mpesa + pdq;
        tenderedDiv.value = ctotal.toFixed(2);

        let variance = 0;
        variance = selectedTotal - ctotal;
        console.log(variance);
        varianceDiv.value = variance.toFixed(2);
    }


    //calculate the variance
</script>