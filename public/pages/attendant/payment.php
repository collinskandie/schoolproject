<?php
$title = "Payment";
include('master.php');
$pump = $_POST['pump'];
$fueltype = $_POST['fueltype'];
$quantity = $_POST['quantity'];
$total = $_POST['total'];
// echo ($total);
?>

<style>
    .button {
        border-radius: 10px;
        width: 64%;
        padding: 10px;
        background-color: #f79974;
        color: white;
        border: none;
        cursor: pointer;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 40px;
        border-radius: 10px;
    }

    .pump-details {
        display: flex;
        /* align-items: center; */
        margin-bottom: 20px;
        margin-top: 0px;
    }

    .pump-details img {
        width: 100px;
        height: auto;
        margin-right: 20px;
        border-radius: 5px;
    }

    .fuel-type {
        margin-bottom: 10px;
        max-width: 100%;
    }

    .form-group {
        display: flex;
        margin-bottom: 20px;
    }

    .form-group label {
        min-width: 150px;
        margin-right: 10px;
        font-weight: bold;
    }

    .form-group select,
    .form-group input[type="select"],
    .form-group input[type="text"],
    .form-group input[type="number"] {
        flex: 1;
        padding: 5px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .total-price {
        text-align: center;
        font-size: 20px;
        margin-bottom: 30px;
    }

    .payment-button {
        text-align: center;
    }

    .payment-button button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .payment-button button:hover {
        background-color: #45a049;
    }
</style>
<br>
<?php
//get fuel type name
$result = $pumps->fuelPrices($fueltype);

?>
<div class="container">
    <form action="./submitpayment.php" method="POST">
        <div class="form-group">
            <label for="fuel-type">Pump:</label>
            <input type="number" name="pump" value="<?= $pump; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="fuel-type">Fuel Type:</label>
            <input type="text" name="name" value="<?= $result['name']; ?>" readonly>
            <input type="text" name="fuelid" value="<?= $result['fuel_type']; ?>" hidden>
        </div>
        <div class="form-group">
            <label for="litres">Number of Litres:</label>
            <input type="number" name="quantity" value="<?= $quantity; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="litres">Total due:</label>
            <input type="number" name="total" value="<?= $total; ?>" readonly>
            <input type="number" name="price" value="<?= $result['price']; ?>" readonly>

        </div>
        <div class="total-price">
            <strong>Total Price:</strong> KSH <?= $total; ?>
        </div>
        <p>Choose payment Option</p>
        <div class="form-group">
            <label for="payment-method">Payment Method:</label>
            <select id="payment-method" name="payment-method">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="mpesa">Mpesa</option>
                <option value="voucher">Voucher</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tendered">Amount Tendered:</label>
            <input type="number" id="tendered" name="tendered" oninput="calculateChange()">
        </div>
        <div class="change">
            <strong>Change: KSH <span id="display-change">0.00</span></strong>
            <input type="number" id="change-input" name="change" hidden>
        </div>
        <br>
        <button type="submit" class="button">Tender</button>
    </form>
</div>

<script>
    function calculateChange() {
        var tenderedAmount = parseFloat(document.getElementById("tendered").value);
        var totalDue = parseFloat("<?= $total; ?>");

        if (!isNaN(tenderedAmount) && !isNaN(totalDue)) {
            var change = tenderedAmount - totalDue;
            document.getElementById("display-change").innerText = change.toFixed(2);
            document.getElementById("change-input").value = change.toFixed(2);
        }
    }
</script>