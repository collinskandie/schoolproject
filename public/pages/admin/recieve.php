<?php
$pagename = "Admin - Recieve Items";
include('./adminmaster.php');
?>
<style>
    /* CSS styling for the form layout */
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .table-form {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .table-form th,
    .table-form td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .table-form th {
        background-color: #f2f2f2;
    }

    .total-amount {
        font-weight: bold;
        text-align: right;
    }

    .submit-button {
        text-align: center;
    }

    .submit-button input[type="submit"] {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
<div class="form-container">
    <h1>Receiving Fuel Form</h1>

    <form action="receiveFuel.php" method="POST">
        <div class="form-group">
            <label for="supplier">Supplier:</label>
            <input type="text" id="supplier" name="supplier" placeholder="Enter  Supplier name">
        </div>

        <div class="form-group">
            <label for="vehicle-type">Vehicle Type:</label>
            <input type="text" id="vehicle-type" name="vehicle-type" placeholder="Enter Vehicle Type">
        </div>

        <div class="form-group">
            <label for="driver-name">Driver Name:</label>
            <input type="text" id="driver-name" name="driver-name" placeholder="Enter Driver Name">
        </div>

        <table class="table-form" id="itemsTable">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity (Litres)</th>
                    <th>Cost (per Litre)</th>
                    <th>Sub-Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="itemsTableBody">
                <tr>
                    <td>
                        <select name="item[]" class="item-select" placeholder="Select Item">
                            <option value="">Select Item</option>
                            <?php
                            $result = $pumps->fetchItems();
                            foreach ($result as $row) {
                            ?>
                                <option value="<?= $row['id'] ?>" data-cost="<?= $row['cost']; ?>"><?= $row['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantity[]" min="0" step="0.01" value="1" placeholder="Enter Quantity">
                    </td>
                    <td>
                        <input type="number" name="cost[]" min="0" step="0.01" value="0" placeholder="Item Cost">
                    </td>
                    <td>
                        <input type="number" name="sub-total[]" min="0" step="0.01" value="0" placeholder="Total" readonly>
                    </td>
                    <td>
                        <button type="button" class="remove-row">Remove</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="total-amount" colspan="2">Total: Ksh 0.00</td>
                </tr>
            </tfoot>
        </table>
        <div class="add-row-button">
            <button type="button" id="addRowButton">Add Row</button>
        </div>

        <div class="submit-button">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

<script>
    // Get all the item select elements
    const itemSelects = document.querySelectorAll('.item-select');

    // Attach change event listener to each item select
    itemSelects.forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            // Get the selected option
            const selectedOption = this.options[this.selectedIndex];

            // Get the corresponding cost input element
            const costInput = this.parentNode.parentNode.querySelector('input[name="cost[]"]');

            // Set the cost input value based on the data-cost attribute of the selected option
            costInput.value = selectedOption.getAttribute('data-cost');

            // Calculate the subtotal for the row
            const quantityInput = this.parentNode.parentNode.querySelector('input[name="quantity[]"]');
            const subTotalInput = this.parentNode.parentNode.querySelector('input[name="sub-total[]"]');
            const quantity = parseFloat(quantityInput.value);
            const cost = parseFloat(costInput.value);
            const subTotal = quantity * cost;
            subTotalInput.value = subTotal.toFixed(2);

            // Calculate the total for the entire table
            calculateTotal();
        });
    });

    // Quantity and Cost change event listeners
    const quantityInputs = document.querySelectorAll('input[name="quantity[]"]');
    const costInputs = document.querySelectorAll('input[name="cost[]"]');

    quantityInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            calculateSubtotal(this);
            calculateTotal();
        });
    });

    costInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            calculateSubtotal(this);
            calculateTotal();
        });
    });

    // Function to calculate the subtotal for a row
    function calculateSubtotal(input) {
        const row = input.parentNode.parentNode;
        const quantityInput = row.querySelector('input[name="quantity[]"]');
        const costInput = row.querySelector('input[name="cost[]"]');
        const subTotalInput = row.querySelector('input[name="sub-total[]"]');
        const quantity = parseFloat(quantityInput.value);
        const cost = parseFloat(costInput.value);
        const subTotal = quantity * cost;
        subTotalInput.value = subTotal.toFixed(2);
    }

    // Function to calculate the total for the entire table
    function calculateTotal() {
        const subTotalInputs = document.querySelectorAll('input[name="sub-total[]"]');
        let total = 0;
        subTotalInputs.forEach(function(input) {
            total += parseFloat(input.value);
        });
        const totalAmount = document.querySelector('.total-amount');
        totalAmount.textContent = 'Total: KSH ' + total.toFixed(2);
    }

    // Get the table body element
    const itemsTableBody = document.getElementById('itemsTableBody');

    function addRow() {
        const newRow = document.createElement('tr');

        const itemCell = document.createElement('td');
        itemCell.innerHTML = `
    <select name="item[]" class="item-select" placeholder="Select Item">
      <option value="">Select Item</option>
      <?php
        foreach ($result as $row) {
        ?>
        <option value="<?= $row['id'] ?>" data-cost="<?= $row['cost']; ?>"><?= $row['name']; ?></option>
      <?php
        }
        ?>
    </select>
  `;

        const quantityCell = document.createElement('td');
        quantityCell.innerHTML = '<input type="number" name="quantity[]" min="0" step="0.01" value="1" placeholder="Enter Quantity">';

        const costCell = document.createElement('td');
        costCell.innerHTML = '<input type="number" name="cost[]" min="0" step="0.01" value="0" placeholder="Item Cost">';
        const subTotalCell = document.createElement('td');
        subTotalCell.innerHTML = '<input type="number" name="sub-total[]" min="0" step="0.01" value="0" placeholder="Subtotal" readonly>';

        const actionsCell = document.createElement('td');
        actionsCell.innerHTML = '<button type="button" class="remove-row">Remove</button>';

        newRow.appendChild(itemCell);
        newRow.appendChild(quantityCell);
        newRow.appendChild(costCell);
        newRow.appendChild(subTotalCell);
        newRow.appendChild(actionsCell);

        itemsTableBody.appendChild(newRow);

        // Attach change event listener to the new item select
        const newItemSelect = newRow.querySelector('.item-select');
        newItemSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const newCostInput = this.parentNode.parentNode.querySelector('input[name="cost[]"]');
            newCostInput.value = selectedOption.getAttribute('data-cost');

            // Calculate the subtotal for the row
            calculateSubtotal(newCostInput);
            calculateTotal();
        });

        // Attach input event listener to the new quantity input
        const newQuantityInput = newRow.querySelector('input[name="quantity[]"]');
        newQuantityInput.addEventListener('input', function() {
            calculateSubtotal(this);
            calculateTotal();
        });

        // Attach input event listener to the new cost input
        const newCostInput = newRow.querySelector('input[name="cost[]"]');
        newCostInput.addEventListener('input', function() {
            calculateSubtotal(this);
            calculateTotal();
        });
    }


    // Add Row Button click event listener
    document.getElementById('addRowButton').addEventListener('click', function() {
        addRow();
    });

    // Remove Row Button click event listener
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-row')) {
            removeRow(event.target);
        }
    });

    // Function to remove a row
    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        // Recalculate the total after removing a row
        calculateTotal();
    }
</script>