<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kerarpon Fuel Attendant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- the code above is to be removed -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="./static/css/index.css" rel="stylesheet">
</head>
<body>
    <?php
    include("../controllers/session.php");  

    ?>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="./static/images/logo.png" alt="Shell Kerarapon">
                </div>
                <h1>Shell Kerarapon System</h1>                
                <div class="user-info">
                    <span class="username">Welcome, Jane Doe</span>
                    <button class="logout-button">Logout</button>
                </div>

            </div>
        </div>
    </header>
    <main>
       
        <section onclick="location.href='/sales';" style="margin-top: 30px;">
            <i class="fas fa-cash-register"></i>
            <h2>Make a Sale</h2>
            <p>Record a new sale transaction and update inventory.</p>
        </section>
        <section onclick="location.href='/sales';">
            <i class="fas fa-cash-register"></i>
            <h2>Check Out</h2>
            <p>Make cash deposit</p>
        </section>
        <section onclick="location.href='/maintenance';">
            <i class="fas fa-toolbox"></i>
            <h2>Request Maintenance</h2>
            <p>Report any issues with pumps, tanks, or equipment.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
    </footer>
</body>

</html>