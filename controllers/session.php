<?php
    session_start();
    if (!$_SESSION['id']) {
        header("Location: ../pages/login.php");
    }    
?>