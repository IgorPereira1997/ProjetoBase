<?php
    session_start();
    unset($_SESSION["user_portal"]);
    session_destroy();
    header("location:login.php");
?>