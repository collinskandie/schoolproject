<?php
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
        background-color: #4CAF50;
        border-radius: 8px;
        color: #fff;
        cursor: pointer;
        font-size: 18px;
        margin: 10px;
        padding: 20px 40px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .option:hover {
        background-color: #45a049;
    }
</style>
<div class="container">
    <h1>Welcome, <?= $name ?>!</h1>
    <div class="options-container">
        <a href="make-sale.php" class="option">Make a Sale</a>
        <a href="cash-out.php" class="option">Cash-out</a>
    </div>
</div>