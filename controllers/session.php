<?php
session_start();
if (!$_SESSION['id']) {
    header("Location: ../public/pages/login.php");
}
