<?php
$pagename = "Admin - Reports";
include('./adminmaster.php');
$attendantsData = $reports->getAttendants();
$allInventory = $pumps->inventoryAll();
$stockAdjustment = $reports->getAdjustment();
?>
<style>
    .tabs {
        overflow: hidden;
        background-color: #f1f1f1;
        display: flex;
        width: 100%;
    }

    .tablink {
        background-color: #ccc;
        flex-grow: 1;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }

    input,
    select {
        /* width: 100%; */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .tablink:hover {
        background-color: #aaa;
    }

    .tablink.active {
        background-color: #ddd;
    }

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
</style>

<div class="tabs">
    <button class="tablink active" onclick="openReport(event, 'sales')">Sales</button>
    <button class="tablink" onclick="openReport(event, 'orders')">Purchase Orders</button>
    <button class="tablink" onclick="openReport(event, 'attendants')">Attendants</button>
    <button class="tablink" onclick="openReport(event, 'items')">Items Value List</button>
    <button class="tablink" onclick="openReport(event, 'stock-take')">Physical Inventory</button>
</div>

<div id="sales" class="report-tab">
    <h2>Sales Report</h2>
    <hr>
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
        <br>
        <br>
        <label for="item">Filter by Reciept No:</label>
        <input type="text" id="item" onchange="applyFilterItem()" placeholder="Enter Recipt No">
    </div>
    <br>

    <p id="total-sales-row">Total Sales:
        <br>
        Days sale: <span id="total-sales-date"></span>
        <br>
        Attendant:<span id="total-sales-attendant"></span>
        <br>
        Total per Receipt <span id="total-sales-item"></span>
    </p>
    <div class="sales-table">
        <table id="sales-table">
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Attendant</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <tr>

                </tr>
            </thead>
            <?php
            // Get sales data
            $results = $reports->allSales();
            ?>
            <tbody id="sales-table-body">
                <?php
                foreach ($results as $sale) {
                ?>
                    <tr>
                        <td><?= $sale['id']; ?></td>
                        <td><?= $sale['date_sold']; ?></td>
                        <td><?= $sale['salesperson_id']; ?></td>
                        <td><?= $sale['item_quantity']; ?></td>
                        <td><?= $sale['price']; ?></td>
                        <td><?= $sale['total']; ?></td>
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
</div><!-- purchase order section -->
<div id="orders" class="report-tab">
    <h2>Purchase Orders</h2>
    <br>
    <div class="filters">
        <label for="date">Filter by Date:</label>
        <input type="date" id="po-date" oninput="applyPOFilter()">
        <label for="attendant">Filter by Attendant:</label>
        <select id="po-attendant" onchange="applyPOFilterAttendant()">
            <option value="all">All Users</option>
            <option value="">No user</option>
            <?php
            // $users = $users->getAllUsers();
            foreach ($users as $user) {
            ?>
                <option value="<?= $user['id']; ?>"><?= $user['username']; ?></option>
            <?php
            }
            ?>
        </select>

        <br>
        <br>
        <label for="item">Filter by PO:</label>
        <input type="text" id="po-item" onchange="applyPOFilterItem()" placeholder="Enter Purchase Order No">
    </div>
    <br>

    <p id="total-po-row">Total PO: KSH:
        <span id="total-po-date"></span>
        <span id="total-po-attendant"></span>
        <span id="total-po-item"></span>
    </p>
    <div class="po-table">
        <table id="po-table">
            <thead>
                <tr>
                    <th>PO number</th>
                    <th>Date</th>
                    <th>Attendant</th>
                    <th>Item Count</th>
                    <th>Total PO Cost</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <?php
                // Get sales data
                $results = $reports->allPo();
                foreach ($results as $po) {
                ?>
                    <tr>
                        <td><?= $po['PO_number']; ?></td>
                        <td><?= $po['date']; ?></td>
                        <td><?= $po['user']; ?></td>
                        <td><?= $po['items_count']; ?></td>
                        <td><?= $po['total_cost']; ?></td>
                        <td><?= $po['time']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function applyPOFilter() {
            var selectedPoDate = document.getElementById("po-date").value;
            var tablePoRows = document.querySelectorAll("#po-table tbody tr");

            var totalPo = 0;

            Array.from(tablePoRows).forEach(function(row) {
                var datePoCell = row.querySelector("td:nth-child(2)");
                var dataPoDate = datePoCell.textContent.trim();

                var totalPoCell = row.querySelector("td:nth-child(5)");
                var poTotal = parseFloat(totalPoCell.textContent.trim());

                if (dataPoDate === selectedPoDate) {
                    row.style.display = "";
                    totalPo += poTotal;
                } else {
                    row.style.display = "none";
                }
            });

            // Display the total PO for the selected date
            var totalPoElement = document.getElementById("total-po-date");
            totalPoElement.textContent = totalPo.toFixed(2); // Adjust decimal places as needed
        }

        function applyPOFilterAttendant() {
            var selectedPoAttendant = document.getElementById("po-attendant").value;
            var tablePoRows = document.querySelectorAll("#po-table tbody tr");

            var totalPo = 0;

            Array.from(tablePoRows).forEach(function(row) {
                var attendantPoCell = row.querySelector("td:nth-child(3)");
                var dataPoAttendant = attendantPoCell.textContent.trim();

                var totalPoCell = row.querySelector("td:nth-child(5)");
                var poTotal = parseFloat(totalPoCell.textContent.trim());

                if (dataPoAttendant === "all" || dataPoAttendant === selectedPoAttendant) {
                    row.style.display = "";
                    totalPo += poTotal;
                } else {
                    row.style.display = "none";
                }
            });

            // Display the total PO for the selected attendant
            var totalPoElement = document.getElementById("total-po-attendant");
            totalPoElement.textContent = totalPo.toFixed(2); // Adjust decimal places as needed
        }

        function applyPOFilterItem() {
            var selectedPoItem = document.getElementById("po-item").value.toLowerCase();
            var tablePoRows = document.querySelectorAll("#po-table tbody tr");

            var totalPo = 0;

            Array.from(tablePoRows).forEach(function(row) {
                var productPoCell = row.querySelector("td:nth-child(1)");
                var dataPoProduct = productPoCell.textContent.trim().toLowerCase();

                var totalPoCell = row.querySelector("td:nth-child(5)");
                var poTotal = parseFloat(totalPoCell.textContent.trim());

                if (dataPoProduct.includes(selectedPoItem)) {
                    row.style.display = "";
                    totalPo += poTotal;
                } else {
                    row.style.display = "none";
                }
            });

            // Display the total PO for the selected item
            var totalPoElement = document.getElementById("total-po-item");
            totalPoElement.textContent = totalPo.toFixed(2); // Adjust decimal places as needed
        }
    </script>
</div>

<div id="attendants" class="report-tab">
    <h1>Attendant</h1>
    <p>Sales per attendant
    <p>
    <div class="attendant-table">
        <table id="attendant-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody id="attendant-table-body">
                <?php
                // Get sales data

                foreach ($attendantsData as $attendant) {
                ?>
                    <tr>
                        <td><?= $attendant['id']; ?></td>
                        <td><?= $attendant['username']; ?></td>
                        <?php
                        if (!$attendant['total_sales']) {
                            $sales = 0;
                        } else {
                            $sales = $attendant['total_sales'];
                        }
                        ?>
                        <td><?= $sales; ?></td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div id="items" class="report-tab">
    <h2>Items Value List</h2>
    <p>Value of stock
    <p>
    <div class="attendant-table">
        <table id="attendant-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>cost per unit</th>
                    <th>Price per unit</th>
                    <th>Quantity</th>
                    <th>Total cost</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody id="attendant-table-body">
                <?php
                // Get sales data
                $tablePrice = 0;
                $tableCost = 0;

                foreach ($allInventory as $stock) {
                ?>
                    <tr>
                        <td><?= $stock['id']; ?></td>
                        <td><?= $stock['name']; ?></td>
                        <td><?= $stock['cost']; ?></td>
                        <td><?= $stock['price']; ?></td>
                        <td><?= $stock['quantity']; ?></td>
                        <?php
                        $totalcost = $stock['cost'] * $stock['quantity'];
                        $totalprice =  $stock['price'] * $stock['quantity'];

                        $tablePrice += $totalprice;
                        $tableCost +=  $totalcost;

                        ?>
                        <td><?= $totalcost; ?></td>
                        <td><?= $totalprice; ?></td>

                    </tr>
                <?php
                }
                ?>

            </tbody>
            <tfoot>

            </tfoot>

        </table>
    </div>
    <br>
    <br>
    <br>
    <tr>Total Cost : <strong>KSH: <?= $tableCost; ?></strong></tr>
    <br>
    <br>
    <tr>Total Price :<strong>KSH: <?= $tablePrice; ?></strong></tr>
    <!-- Other report content goes here -->
</div>
<div id="stock-take" class="report-tab">
    <h2>Physical Inventory</h2>
    <p>Stock adjustment report
    <p>
        <hr>
    <div class="filters">
        <label for="date">Filter by Date:</label>
        <input type="date" id="pidate" oninput="filterPIdate()">
        <label for="attendant">Filter by Attendant:</label>
        <select id="pi-attendant" onchange="filterByUser()">
            <option value="all">All Users</option>
            <option value="">No user</option>
            <?php
            foreach ($users as $user) {
            ?>
                <option value="<?= $user['username']; ?>"><?= $user['username']; ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <br>
    </div>
    <div class="attendant-table">
        <table id="attendant-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody id="attendant-table-body">
                <?php
                foreach ($stockAdjustment as $stockAdj) {
                ?>
                    <tr>
                        <td><?= $stockAdj['id'] ?></td>
                        <td><?= $stockAdj['date'] ?></td>
                        <td><?= $stockAdj['time'] ?></td>
                        <td><?= $stockAdj['username'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function filterPIdate() {
        var selectedDate = document.getElementById("pidate").value;
        var tableRows = document.querySelectorAll("#attendant-table tbody tr");

        Array.from(tableRows).forEach(function(row) {
            var dateCell = row.querySelector("td:nth-child(2)");
            var dataDate = dateCell.textContent.trim();

            if (dataDate === selectedDate) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function filterByUser() {
        var selectedAttendant = document.getElementById("pi-attendant").value;
        var tableRows = document.querySelectorAll("#attendant-table tbody tr");

        Array.from(tableRows).forEach(function(row) {
            var attendantCell = row.querySelector("td:nth-child(4)");
            var dataAttendant = attendantCell.textContent.trim();

            if (dataAttendant === selectedAttendant) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.tablink.active').click();
    });

    function openReport(evt, reportName) {
        var i, reportTab, tablink;

        reportTab = document.getElementsByClassName("report-tab");
        for (i = 0; i < reportTab.length; i++) {
            reportTab[i].style.display = "none";
        }

        tablink = document.getElementsByClassName("tablink");
        for (i = 0; i < tablink.length; i++) {
            tablink[i].className = tablink[i].className.replace(" active", "");
        }

        document.getElementById(reportName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>