<?php
$title = "Make a sale";
include('master.php');

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
$id = $_GET['pump'];
$fuel_types = $pumps->fuelTypes();
?>
<div class="container">
    <form action="payment.php" method="POST">
        <div class="pump-details">
            <img src="../../static/images/gas.jpg" alt="Gas Pump <?= $id; ?>">
            <h3>Pump <?= $id; ?> </h3>
            <input type="number" name="pump" value="<?= $id; ?>" hidden>
        </div>
        <div class="form-group">
            <div class="fuel-type">
                <label for="fuel-type">Fuel Type:</label>
                <select type="select" min="0" step="0.01" id="fuel-type" name="fueltype" style="max-width: 1000px;">
                    <?php
                    if (count($fuel_types) > 0) {
                        foreach ($fuel_types as $row) {
                    ?>
                            <option value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>"><?= $row['name']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="litres">Number of Litres:</label>
            <input type="number" id="litres" name="quantity" min="0" step="0.01" oninput="calculateTotalPrice()">
        </div>

        <div class="form-group">
            <label for="total-price">Total Price:</label>
            <input type="number" name="total" id="total-price" min="0" step="0.01" readonly>
        </div>

        <div class="total-price">
            <strong>Total Price:</strong> KSH <span id="display-price">0.00</span>
        </div>
        <div class="payment-button">
            <button type="submit" id="payment-button">Make Payment</button>
        </div>

    </form>
</div>
<script>
    function calculateTotalPrice() {
        var fuelTypeSelect = document.getElementById("fuel-type");
        var fuelPrice = parseFloat(fuelTypeSelect.options[fuelTypeSelect.selectedIndex].getAttribute("data-price"));
        var litres = parseFloat(document.getElementById("litres").value);

        if (!isNaN(fuelPrice) && !isNaN(litres)) {
            var totalPrice = fuelPrice * litres;
            document.getElementById("total-price").value = totalPrice.toFixed(2);
            document.getElementById("display-price").innerText = totalPrice.toFixed(2);
        }
    }
</script>