<?php
$pagename = "Admin - Analytics";
include('./adminmaster.php');

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pagename ?></title>
    <style>
        .graph {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        #salesChartContainer {
            position: relative;
            width: 100%;
            height: 400px;
        }

        #salesCanvas {
            width: 100%;
            height: 100%;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .graph-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .no-data-message {
            font-size: 16px;
            color: #888;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <h1><?= $pagename ?></h1>
    <div class="graph">
        <h2 class="graph-title">Sales Graph</h2>
        <div id="salesChartContainer">
            <canvas id="salesCanvas"></canvas>
        </div>
        <p class="no-data-message" id="noDataMessage">No sales recorded.</p>
    </div>

    <script>
        const salesData = <?= json_encode($dataPoints) ?>;
        const xMin = <?= $xMin ?>;
        const xMax = <?= $xMax ?>;
        const yMin = <?= $yMin ?>;
        const yMax = <?= $yMax ?>;
        const graphContainer = document.getElementById('salesChartContainer');
        const canvas = document.getElementById('salesCanvas');
        const ctx = canvas.getContext('2d');
        const yPadding = 40;
        const xPadding = 40;

        canvas.width = graphContainer.offsetWidth;
        canvas.height = graphContainer.offsetHeight;

        if (salesData.length === 0) {
            document.getElementById('noDataMessage').style.display = 'block';
        } else {
            document.getElementById('noDataMessage').style.display = 'none';

            // Calculate scaling factors
            const xScale = (canvas.width - 2 * xPadding) / (xMax - xMin);
            const yScale = (canvas.height - 2 * yPadding) / (yMax - yMin);

            // Draw graph
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.beginPath();
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#007bff';

            for (let i = 0; i < salesData.length; i++) {
                const data = salesData[i];
                const x = xPadding + (data.x - xMin) * xScale;
                const y = canvas.height - yPadding - (data.y - yMin) * yScale;

                if (i === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            }

            ctx.stroke();
            ctx.closePath();
        }
    </script>
</body>

</html>