<?php
$title = "Sale";
include('master.php');

?>
<style>
    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 300px;
        padding: 20px;
        margin: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .card img {
        width: 200px;
        height: auto;
        margin-bottom: 5px;
    }

    .card h6 {
        text-align: center;
        margin-bottom: 5px;
    }

    .card p {
        text-align: justify;
        line-height: 1.5;
    }

    .button {
        border-radius: 10px;
        width: 64%;
        padding: 10px;
        background-color: #f79974;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
<link rel="stylesheet" href="../../static/css/newcustom.css">
<?php
// $users->userLogin($email, $new_password);
$result = $pumps->allPumps();
?>
<br>
<h6 style="margin-left: 100px;">Select Fuel pump</h6>
<div class="card-container" style="margin-left: 100px;">

    <?php
    if (count($result) > 0) {
        foreach ($result as $row) {
    ?>
            <div class="card">
                <img src="../../static/images/gas.jpg" alt="Gas Pump">
                <h6>Pump <?= $row["id"]; ?></h6>
                <p> <?= $row["pump_details"] ?></p>
                <button class="button" onclick='window.location.href = "sale.php?pump=<?= $row["id"]; ?>"'> Select </button>
            </div>
    <?php
        }
    } else {
        echo '<div class="card">
        <p>No pumps found. </p>
     </tr>';
    }
    ?>
</div>