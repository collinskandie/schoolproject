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
        margin-bottom: 20px;
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
    <div class="pump-details">
        <img src="../../static/images/gas.jpg" alt="Gas Pump 1">
        <h3>Pump <?= $id; ?> </h3>
    </div>
    <div class="fuel-type">
        <label for="fuel-type">Fuel Type:</label>
        <select id="fuel-type">
            <?php
            if (count($fuel_types) > 0) {
                foreach ($fuel_types as $row) {
            ?>
                    <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="litres">Number of Litres:</label>
        <input type="number" id="litres" min="0" step="0.01">
    </div>
    <div class="form-group">
        <label for="total-price">Total Price:</label>
        <input type="number" id="total-price" min="0" step="0.01" readonly>
    </div>
    <div class="total-price">
        <strong>Total Price:</strong> KSH <span id="display-price">0.00</span>
    </div>
    <div class="payment-button">
        <button id="payment-button">Make Payment</button>
    </div>
</div>

<script>
    // Calculate and update the total price based on liters entered
    const litresInput = document.getElementById('litres');
    const totalPriceInput = document.getElementById('total-price');
    const displayPrice = document.getElementById('display-price');

    litresInput.addEventListener('input', () => {
        const litres = litresInput.value;
        const fuelType = document.getElementById('fuel-type').value;
        const fuelPricePerLitre = getFuelPrice(fuelType);
        const totalPrice = litres * fuelPricePerLitre;
        totalPriceInput.value = totalPrice.toFixed(2);
        displayPrice.textContent = totalPrice.toFixed(2);
    });

    // Retrieve fuel price based on selected fuel type
    function getFuelPrice(fuelType) {
        // Add your logic here to retrieve the fuel price based on the selected fuel type
        // For demonstration purposes, a sample price is used
        const fuelPrices = {
            petrol: 1.3,
            diesel: 1.2,
            gasoline: 1.5
        };
        return fuelPrices[fuelType] || 0;
    }

    // Handle payment button click
    const paymentButton = document.getElementById('payment-button');
    paymentButton.addEventListener('click', () => {
        const litres = litresInput.value;
        const totalPrice = totalPriceInput.value;
        const fuelType = document.getElementById('fuel-type').value;

        // Add your payment processing logic here
        alert(`Fuel Type: ${fuelType}\nLitres: ${litres}\nTotal Price: $${totalPrice}`);
    });
</script>