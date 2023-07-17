<h2>Purchase Orders</h2>
<br>
<div class="filters">
    <label for="date">Filter by Date:</label>
    <input type="date" id="date" oninput="applyFilter()">
    <label for="attendant">Filter by Attendant:</label>
    <select id="attendant" onchange="applyFilterAttendant()">
        <option value="all">All Users</option>
        <option value="">No user</option>
        <?php
        $users = $users->getAllUsers();
        foreach ($users as $user) {
        ?>
            <option value="<?= $user['id']; ?>"><?= $user['username']; ?></option>
        <?php
        }
        ?>
    </select>
    <label for="item">Filter by Item:</label>
    <input type="text" id="item" onchange="applyFilterItem()" placeholder="Enter Item ID/Lookup">
</div>
<br>

<p id="total-sales-row">Total Sales: KSH:
    <span id="total-sales-date"></span>
    <span id="total-sales-attendant"></span>
    <span id="total-sales-item"></span>
</p>
<div class="sales-table">
    <table id="sales-table">
        <thead>
            <tr>
                <th>PO number</th>
                <th>Date</th>
                <th>Attendant</th>
                <th>Item Count</th>
                <th>Total PO Cost</th>
                <th>Time</th>
            </tr>
            <tr>

            </tr>
        </thead>
        <?php
        // Get sales data
        $results = $reports->allPo()
        ?>
        <tbody id="sales-table-body">
            <?php
            foreach ($results as $sale) {
            ?>
                <tr>
                    <td><?= $sale['PO_number']; ?></td>
                    <td><?= $sale['date']; ?></td>
                    <td><?= $sale['user']; ?></td>
                    <td><?= $sale['items_count']; ?></td>
                    <td><?= $sale['total_cost']; ?></td>
                    <td><?= $sale['time']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<script>
    function applyFilter() {
        var selectedDate = document.getElementById("date").value;
        var tableRows = document.querySelectorAll("#sales-table tbody tr");

        var totalSales = 0;

        Array.from(tableRows).forEach(function(row) {
            var dateCell = row.querySelector("td:nth-child(2)");
            var dataDate = dateCell.textContent.trim();

            var totalCell = row.querySelector("td:nth-child(6)");
            var saleTotal = parseFloat(totalCell.textContent.trim());

            if (dataDate === selectedDate) {
                row.style.display = "";
                totalSales += saleTotal;
            } else {
                row.style.display = "none";
            }
        });

        // Display the total sales for the selected date
        var totalSalesElement = document.getElementById("total-sales-date");
        totalSalesElement.textContent = totalSales.toFixed(2); // Adjust decimal places as needed
    }

    function applyFilterAttendant() {
        var selectedAttendant = document.getElementById("attendant").value;
        var tableRows = document.querySelectorAll("#sales-table tbody tr");

        var totalSales = 0;

        Array.from(tableRows).forEach(function(row) {
            var attendantCell = row.querySelector("td:nth-child(3)");
            var dataAttendant = attendantCell.textContent.trim();

            var totalCell = row.querySelector("td:nth-child(6)");
            var saleTotal = parseFloat(totalCell.textContent.trim());

            if (dataAttendant === "all" || dataAttendant === selectedAttendant) {
                row.style.display = "";
                totalSales += saleTotal;
            } else {
                row.style.display = "none";
            }
        });

        // Display the total sales for the selected attendant
        var totalSalesElement = document.getElementById("total-sales-attendant");
        totalSalesElement.textContent = totalSales.toFixed(2); // Adjust decimal places as needed
    }

    function applyFilterItem() {
        var selectedItem = document.getElementById("item").value.toLowerCase();
        var tableRows = document.querySelectorAll("#sales-table tbody tr");

        var totalSales = 0;

        Array.from(tableRows).forEach(function(row) {
            var productCell = row.querySelector("td:nth-child(1)");
            var dataProduct = productCell.textContent.trim().toLowerCase();

            var totalCell = row.querySelector("td:nth-child(6)");
            var saleTotal = parseFloat(totalCell.textContent.trim());

            if (dataProduct.includes(selectedItem)) {
                row.style.display = "";
                totalSales += saleTotal;
            } else {
                row.style.display = "none";
            }
        });

        // Display the total sales for the selected item
        var totalSalesElement = document.getElementById("total-sales-item");
        totalSalesElement.textContent = totalSales.toFixed(2); // Adjust decimal places as needed

        totalSalesElement = document.getElementById("totalSalesElement");
    }
</script>