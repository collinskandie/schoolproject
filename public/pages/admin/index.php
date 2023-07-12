<?php
$pagename = "Admin - Dashboard";
include('./adminmaster.php');
?>

<head>
    <meta charset="UTF-8">
    <title><?= $pagename; ?></title>
    <link rel="stylesheet" href="../../static/css/newcustom.css">
</head>
<main>
    <h4>Welcome <?= $name ?> </h4>
    <h5>Todays Summary </h5>
    <div class="card-container">
        <div class="card">
            <div class="card-header">
                Top Pump Today
            </div>
            <div class="card-body">
                <?php
                $result = $reports->activePump();
                // var_dump($result);
                if (!$result) {
                    $pump = "No data";
                } else {
                    $pump = $result['pump_details'];
                }

                ?>
                <p class="card-text"><?= $pump;  ?></p>
            </div>
        </div>
        <div class="card">
            <?php
            $result = $reports->topAttendant();
            // var_dump($result);
            if (!$result) {
                $user = "No sales data";
            } else {
                $user = $result['username'];
            }
            ?>
            <div class="card-header">
                Top Attendant
            </div>
            <div class="card-body">
                <p class="card-text"><?= $user; ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Fuel Tanks Level
            </div>
            <div class="card-body">
                <p class="card-text">Tank 1: 60%</p>
                <p class="card-text">Tank 2: 80%</p>
                <p class="card-text">Tank 3: 30%</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Total Day's Sales
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php
                    $result = $reports->totalSales();
                    ?>
                </p>
            </div>
        </div>
    </div>



</main>