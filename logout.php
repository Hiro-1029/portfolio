<?php

session_start();
session_destroy();
unset($_SESSION['login_id']);
unset($_SESSION['message']);

header("Location: login.php");