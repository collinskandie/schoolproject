<?php
$pagename = "Admin - Stock Feedback";
include('./adminmaster.php');

$ids = $_POST['id'];
$names = $_POST['names'];
$countedValues = $_POST['counted'];

if (!empty($ids) && !empty($countedValues) && count($ids) === count($countedValues)) {
    $actualQuantities = array();
    $idPlaceholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE id IN ($idPlaceholders)");
    $stmt->execute($ids);
    $actualQuantities = $stmt->fetchAll(PDO::FETCH_COLUMN);


    // echo '<table>';
    // echo '<thead>';
    // echo '<tr>';
    // echo '<th>ID</th>';
    // echo '<th>Actual</th>'; // Added column header
    // echo '<th>Counted</th>';
    // echo '<th>Delta</th>'; // Added column header
    // echo '</tr>';
    // echo '</thead>';
    // echo '<tbody>';

    // for ($i = 0; $i < count($ids); $i++) {
    //     echo '<tr>';
    //     echo '<td>' . $ids[$i] . '</td>';
    //     echo '<td>' . $names[$i] . '</td>';
    //     echo '<td>' . $actualQuantities[$i] . '</td>';
    //     echo '<td>' . $countedValues[$i] . '</td>';
    //     $delta = $actualQuantities[$i] - $countedValues[$i];
    //     echo '<td>' . $delta . '</td>'; // Added delta column
    //     echo '</tr>';
    // }
}
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
    <h1> <?php echo date('Y-m-d'); ?></h1>
    <!-- <p>User: John Doe</p> -->

    <form action="stocktakerepo.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Name</th>
                    <th>Actual Figures</th>
                    <th>Counted</th>
                    <th>Delta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($ids); $i++) {
                    echo '<tr>';
                    echo '<td>' . $ids[$i] . '</td>';
                    echo '<td>' . $names[$i] . '</td>';
                    echo '<td>' . $actualQuantities[$i] . '</td>';
                    echo '<td>' . $countedValues[$i] . '</td>';
                    $delta = $countedValues[$i] - $actualQuantities[$i];
                    echo '<td>' . $delta . '</td>'; // Added delta column
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <button type="submit">Submit</button>
        <br>
        <a class="button" href="./stocktake.php">Recount</a>
    </form>
</div>
</body>

</html>