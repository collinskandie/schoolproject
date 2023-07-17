  <?php
    session_start();
    if (isset($_SESSION['id'])) {
        echo ('404 error! You have an exhisting session my guy!');
        if ($_SESSION['role'] == "admin") {

            header('Location: ./admin/index.php');
        } else {
            header('Location: ./attendant/index.php');
        }
        exit();
    }
    require_once("../../models/dbcon.php");

    $email = $_POST['email'];
    $password = $_POST['password'];
    $new_password = md5($password . $email);
    $result = $users->resetPassword($email, $new_password);
    if (!$result) {
        echo ('<script>
            alert("Incorrect password or email");
          </script>');
    } else {
        echo ('<script>
            alert("Password changed successfully");
          </script>');
    }
    header('Location: ./login.php');
    ?>
 