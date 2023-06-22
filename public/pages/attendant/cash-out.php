<?php
$title = "Cashout";
include('master.php');
$user = $_SESSION['id'];

// $result = $sales->unCleared($user);
?>
<style>
    /* body {
        font-family: Arial, sans-serif;
        margin: 20px;
    } */

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
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 20px;
        height: 100vh;
    }

    .container {
        flex-direction: column;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 20px;
        /* height: 100vh; */
    }

    #record-table {
        /* margin-top: 20px; */
        margin: 20px;

    }
</style>
<h1>Records Table</h1>
<div class="container">

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
            $result = $sales->unCleared($user);
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
                        <input type="checkbox" name="selected[]" value="<?= $row['pid'] ?>">
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
    <div class="container-2">
        Expected cash: <?= $cash ?>
        <br>
        Expected Mpesa: <?= $mpesa ?>
        <br>
        Expected PDQ: <?= $pdq ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const priceCells = document.getElementsByClassName("price");
        let totalPrice = 0;

        for (let i = 0; i < priceCells.length; i++) {
            const price = parseFloat(priceCells[i].textContent);
            totalPrice += price;
        }

        document.getElementById("total-price").textContent = totalPrice.toFixed(2);
    });
</script>