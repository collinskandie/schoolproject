<?php
include('./adminmaster.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Link to CSS stylesheets and JavaScript files -->
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
                <p class="card-text">Pump 1</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Top Attendant
            </div>
            <div class="card-body">
                <p class="card-text">John Doe</p>
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
                <p class="card-text">$10,000</p>
            </div>
        </div>
    </div>

    </div>

</main>