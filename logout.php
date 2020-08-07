<?php

session_start();
session_destroy();
// $_SESSION = array();
unset($_SESSION['login_id']);
unset($_SESSION['message']);


header("Location: login.php");