<?php

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function start() {
  $_SESSION['start'] = time();
  $_SESSION['expire'] = $_SESSION['start'] + 0.1;
}



