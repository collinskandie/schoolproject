<?php
$title = "Dashboard";
include('master.php');
?>
<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h1 {
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
    }

    .options-container {
        display: flex;
        /* justify-content: center; */
    }

    .option {
        background-color: #f79974;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-size: 18px;
        margin: 10px;
        padding: 20px 40px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    /* .option:hover {
        background-color: #45a049;
    } */
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
<div class="container">
    <h1>Welcome, <?= $name ?>!</h1>

    <div class="options-container">
        <a href="make-sale.php" class="option">Make a Sale</a>
        <a href="cash-out.php" class="option">Cash-out</a>
    </div>
    <script>
        // Check if there's a success message in the URL and display it as a JavaScript alert
        <?php if (isset($_GET['success_message'])) : ?>
            var success_message = "<?php echo $_GET['success_message']; ?>";
            alert(success_message);
        <?php endif; ?>
        <?php if (isset($_GET['error_message'])) : ?>
            var error_message = "<?php echo $_GET['error_message']; ?>";
            alert(error_message);
        <?php endif; ?>
    </script>
</div>