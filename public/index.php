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
    if ($_SESSION['role'] == 'attendant') {
        echo ('<script>
        alert("Login success,Welcome");
      </script>');
        header("Location: ./pages/attendant/index.php");
    } elseif (
        $result['role'] ==
        'admin'
    ) {
        echo ('<script>
        alert("Login success,Welcome to admin page");
      </script>');
        header("Location: ./pages/admin/index.php");
    }

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


    </main>
    <footer>
        <p>&copy; 2023 <a href="https://collinskandie.com">Collins Kandie.</a> All rights reserved.</p>
    </footer>
</body>

</html>