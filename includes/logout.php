<?php 
include '../db.php'; 
session_start();

$_SESSION['user_username'] = null;
$_SESSION['user_firstname'] = null;
$_SESSION['user_lastname'] = null;
$_SESSION['user_role'] = null;

header('Location: ../index.php');




?> 
