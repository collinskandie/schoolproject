<?php
include('./adminmaster.php');
$result = $users->getAllUsers();
// echo ($result[0]);
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    thead {
        background-color: black;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    th {
        background-color: #4CAF50;
        color: white;
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
    <button class="button" onclick="window.location.href = 'createuser.php'">Add User</button>
    <hr>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Last login</th>
                <th>Updated at</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["role"] . "</td>
                    <td>" . $row["last_login"] . "</td>
                    <td>" . $row["updated_at"] . "</td>
                    </tr>";
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