<?php
$pagename = "Admin - User logs";
include('./adminmaster.php');

$results = $users->getLogs();
$users = $users->getAllUsers();
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

    input,
    select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }
</style>
<main>
    <h2>User logs</h2>
    <p>Records of user activities</p>
    <br>
    <div class="filters">
        <label for="date">Filter by Date:</label>
        <input type="date" id="date" oninput="filterPIdate()">
        <br><br>
    </div>

    <table>
        <thead id="attendant-table">
            <tr>
                <th>ID</th>
                <th>Action</th>
                <th>User</th>
                <th>Date</th>
                <th>Time</th>
                <th>Category</th>
                <th>Affected table</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody id="attendant-table-body">
            <?php
            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo "<tr>"; // Add this line
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["actions"] . "</td>";
                    echo "<td>" . $row["actionby"] . "</td>";
                    echo "<td>" . $row["actiondate"] . "</td>";
                    echo "<td>" . $row["actiontime"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["actiontable"] . "</td>";
                    echo "<td>" . $row["user_role"] . "</td>";
                    echo "</tr>"; // Add this line
                }
            } else {
                echo "<tr>
                    <td colspan='8'>No bookings found.</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        function filterPIdate() {
            var selectedDate = document.getElementById("date").value;
            var tableRows = document.querySelectorAll("#attendant-table-body tr");

            Array.from(tableRows).forEach(function(row) {
                var dateCell = row.querySelector("td:nth-child(4)");
                var dataDate = dateCell.textContent.trim();

                if (dataDate === selectedDate) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</main>