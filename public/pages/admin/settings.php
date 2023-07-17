<?php
$pagename = "Admin - Settings";
include('./adminmaster.php');

$results = $sales->getSettings();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $value = $_POST['maxvalue'];
    $result = $sales->updateSettings($id, $value);
    if ($result) {
        echo ("<script>alert('$value updated');</script>");
    }
}
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
    <!-- <button class="button" onclick="window.location.href = 'createuser.php'">Se</button> -->
    <br>
    <br>
    <!-- <hr> -->
    <table>
        <thead>
            <tr>
                <th>Setting ID</th>
                <th>Setting</th>
                <th>Value</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // if ($results) {
            foreach ($results as $row) {
            ?>
                <tr>
                    <form action="" method="POST">
                        <td><input type="text" name="id" value="<?= $row['settings_id']; ?>" style="border: none; background-color: transparent;" readonly></td>
                        <td><?= $row["name"]; ?></td>
                        <td><input type="text" name="maxvalue" value="<?= $row['value']; ?>"></td>
                        <td>
                            <button type="submit" class="button">Edit</button>
                        </td>
                    </form>
                </tr>
            <?php

            }
            // } else {
            //     echo "<tr>
            //     <td colspan='4'>No Settings Found</td>
            //     </tr>";
            // }
            ?>
        </tbody>
    </table>

</main>