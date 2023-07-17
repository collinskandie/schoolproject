<?php
$pagename = "Admin - User";
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
    <button class="button" onclick="window.location.href = 'createuser.php'">Add User</button>
    <br>
    <br>
    <!-- <hr> -->
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Action</th>
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
                    ";
            ?>

                    <td>
                        <button onclick="window.location.href='./useredit.php?id=<?= $row['id']; ?>'" class="button">Edit</button>
                        <button onclick="window.location.href='./userdelete.php?id=<?= $row['id']; ?>'" class="button">Delete</button>
                    </td>

                    </tr>
            <?php
                }
            } else {
                echo "<tr>
                <td colspan='4'>No user found</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

</main>