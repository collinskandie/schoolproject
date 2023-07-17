<?php
$pagename = "Admin - Dashboard";
include('./adminmaster.php');
?>

<head>
    <meta charset="UTF-8">
    <title><?= $pagename; ?></title>
    <link rel="stylesheet" href="../../static/css/newcustom.css">
    <style>
        .tank-sliders {
            display: flex;
            flex-wrap: wrap;
        }

        .tank-slider {
            width: 100%;
            margin: 2px;
        }

        .tank-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .tank-bar {
            background-color: #ddd;
            height: 7px;
            position: relative;
        }

        .tank-fill {
            background-color: #4CAF50;
            height: 100%;
            width: 0;
            transition: width 0.5s ease;
            position: absolute;
            top: 0;
            left: 0;
            text-align: center;
            color: #fff;
            line-height: 20px;
        }

        .red-slider {
            background-color: red;
        }

        .orange-slider {
            background-color: orange;
        }

        .brown-slider {
            background-color: brown;
        }

        .green-slider {
            background-color: green;
        }

        .graph {
            background-color: #fff;
            width: 100%;
            height: 50%;
        }
    </style>
</head>
<main>
    <h4>Welcome <?= $name ?> </h4>
    <h5>Todays Summary </h5>
    <div class="card-container">
        <div class="card" style="align-items:center;height: 400px;">
            <div class="card-header" style="width:100%;">
                Top Pump Today
            </div>
            <br>
            <br>
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
        <div class="card" style="width: 280px; align-items:center;height: 400px;">
            <?php
            $result = $reports->topAttendant();
            // var_dump($result);
            if (!$result) {
                $user = "No sales data";
            } else {
                $user = $result['username'];
            }
            ?>
            <div class="card-header" style="width:100%">
                Top Attendant
            </div>
            <br>
            <br>
            <div class="card-body">
                <p class="card-text"><?= $user; ?></p>
            </div>
        </div>
        <div class="card" style="width: 400px;height: 400px;">
            <div class="card-header">
                Fuel Tanks Level
            </div>
            <div class="card-body">
                <?php
                $result = $reports->fuelCapacity();
                ?>
                <div class="tank-sliders">
                    <?php foreach ($result as $capacity) {
                        $percentage = $capacity['percentage'];
                        $colorClass = '';
                        if ($percentage < 25) {
                            $colorClass = 'red-slider';
                        } elseif ($percentage >= 25 && $percentage < 50) {
                            $colorClass = 'orange-slider';
                        } elseif ($percentage >= 50 && $percentage < 75) {
                            $colorClass = 'brown-slider';
                        } else {
                            $colorClass = 'green-slider';
                        }
                    ?>
                        <div class="tank-slider">
                            <div class="tank-label">
                                Tank: <?= $capacity['tank_details'] ?> || <?= $capacity['percentage']; ?>% || <?= $capacity['name'] ?>
                            </div>
                            <div class="tank-bar">
                                <div class="tank-fill <?= $colorClass ?>" style="width: <?= $percentage ?>%;">
                                </div>
                            </div>
                            <div class="tank-details">
                                Capacity: <?= $capacity['capacity'] ?> | Available: <?= $capacity['available_quantity'] ?>
                            </div>
                        </div>
                    <?php } ?>
                    <hr>
                </div>


            </div>
        </div>
        <!-- <div class="card" style=""> -->
        <div class="card" style="width: 320px; align-items:center;height: 400px; ">
            <div class="card-header" style="width: 100%;">
                Total Day's Sales
            </div>
            <br>
            <br>
            <div class="card-body">
                <p class="card-text">
                    <?php
                    $result = $reports->totalSales();
                    ?>
                </p>
            </div>
        </div>
    </div>
    <hr>
    Sales over time (line graph)
    <!-- <br> -->
    <div class="graph" style="margin:10px">
        <!-- fetch the data from the db  -->
        <?php
        $salesData = $reports->salesOvertime();

        $dataPoints = [];
        $xMin = PHP_INT_MAX;
        $xMax = PHP_INT_MIN;
        $yMin = PHP_INT_MAX;
        $yMax = PHP_INT_MIN;

        foreach ($salesData as $data) {
            $timeSold = strtotime($data['time_sold']) * 1000; // Convert time_sold to milliseconds
            $total = $data['total'];
            $dataPoints[] = [
                'x' => $timeSold,
                'y' => $total
            ];

            if ($timeSold < $xMin) {
                $xMin = $timeSold;
            }
            if ($timeSold > $xMax) {
                $xMax = $timeSold;
            }
            if ($total < $yMin) {
                $yMin = $total;
            }
            if ($total > $yMax) {
                $yMax = $total;
            }
        }
        ?>

        <div id="salesChartContainer" class="sales-chart-container">
            <canvas id="salesChart" style="margin-left: 10px;"></canvas>
        </div>
    </div>

    <!-- Rest of your HTML code -->

    <script>
        const salesData = <?= json_encode($dataPoints) ?>;
        const xMin = <?= $xMin ?>;
        const xMax = <?= $xMax ?>;
        const yMin = <?= $yMin ?>;
        const yMax = <?= $yMax ?>;
        const graphContainer = document.getElementById('salesChartContainer');
        const canvas = document.createElement('canvas');
        canvas.id = 'salesCanvas';
        canvas.width = graphContainer.offsetWidth;
        canvas.height = 300;
        graphContainer.appendChild(canvas);

        const ctx = canvas.getContext('2d');
        const yPadding = 40;
        const xPadding = 40;

        if (salesData.length === 0) {
            ctx.fillStyle = 'black';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = '16px Arial';
            ctx.fillText('No sales recorded', canvas.width / 2, canvas.height / 2);
        } else {
            // Draw ruled background
            ctx.beginPath();
            ctx.lineWidth = 1;
            ctx.strokeStyle = '#e0e0e0';
            for (let y = yPadding; y <= canvas.height - yPadding; y += 20) {
                ctx.moveTo(xPadding, y);
                ctx.lineTo(canvas.width - xPadding, y);
            }
            ctx.stroke();
            // Draw y-axis labels
            ctx.fillStyle = 'black';
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            ctx.font = '12px Arial';

            for (let y = yPadding; y <= canvas.height - yPadding; y += 20) {
                const label = ((canvas.height - y - yPadding) / (canvas.height - 2 * yPadding)) * (yMax - yMin) + yMin;
                ctx.fillText(label.toFixed(2), xPadding - 5, y);
            }

            // Draw x-axis labels
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';
            for (let i = 0; i < salesData.length; i++) {
                const data = salesData[i];
                const x = ((data.x - xMin) / (xMax - xMin)) * (canvas.width - 2 * xPadding) + xPadding;
                const label = new Date(data.x);
                const formattedLabel = label.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric'
                });
                ctx.fillText(formattedLabel, x, canvas.height - yPadding + 5);
            }
            // Draw the line graph
            ctx.beginPath();
            ctx.moveTo(((salesData[0].x - xMin) / (xMax - xMin)) * (canvas.width - 2 * xPadding) + xPadding, canvas.height - ((salesData[0].y - yMin) / (yMax - yMin)) * (canvas.height - 2 * yPadding) - yPadding);

            for (let i = 1; i < salesData.length; i++) {
                const data = salesData[i];
                const x = ((data.x - xMin) / (xMax - xMin)) * (canvas.width - 2 * xPadding) + xPadding;
                const y = canvas.height - ((data.y - yMin) / (yMax - yMin)) * (canvas.height - 2 * yPadding) - yPadding;

                ctx.lineTo(x, y);
            }
            ctx.strokeStyle = 'blue';
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.closePath();
        }
    </script>