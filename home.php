<?php

session_start();

include 'db_connect.php';

if (isset($_SESSION['user'])) {
  if ($_SESSION['is_admin'] == 0) {
    header('location: events.php');
  }
  if ($_SESSION['is_admin'] == 1) {
    header('location: index.php');
  }
}
