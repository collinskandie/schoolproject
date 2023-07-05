<?php
$pagename = "Admin - User logs";
include('./adminmaster.php');

$results = $users->getLogs();
// $result = $users->getUserByEmail($userEmail);
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
</style>
<main>

    <table>
        <thead>
            <!-- id, actions, actionby, actiondate, actiontime, category, actiontable, user_role -->
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
        <tbody>
            <?php
            // id, actions, actionby, actiondate, actiontime, category, actiontable, user_role
            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["actions"] . "</td>
                    <td>" . $row["actionby"] . "</td>
                    <td>" . $row["actiondate"] . "</td>                    
                    <td>" . $row["actiontime"] . "</td>                    
                    <td>" . $row["category"] . "</td>
                    <td>" . $row["actiontable"] . "</td>
                    <td>" . $row["user_role"] . "</td>
                    ";
            ?>
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
</main>