<?php
$pagename = "Admin - Stock Take";
include('./adminmaster.php');
?>
<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
    }

    p {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ccc;
    }

    input[type="number"] {
        width: 100px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    button {
        display: block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
</style>
<div class="container">
    <h1>Stock Taking</h1>
    <h1>Date: <?php echo date('Y-m-d'); ?></h1>
    <!-- <p>User: John Doe</p> -->

    <form action="stocktakerepo.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Name</th>
                    <th>Counted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $items = $pumps->inventoryAll();

                foreach ($items as $item) {
                    echo '<tr>';                ?>
                    <td><input name="id[]" value="<?= $item['id']; ?>" style="border: none; background-color: transparent;" readonly></td>
                    <td><input name="names[]" value="<?= $item['name']; ?>" style="border: none; background-color: transparent;" readonly></td>
                    <td><input type="number" name="counted[]" value="0" step="1" min="0"></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <button type="submit">Calculate</button>
    </form>
</div>
</body>

</html>