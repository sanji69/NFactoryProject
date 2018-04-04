<?php
session_start();

include('inc/pdo.php');
include('inc/function.php');

session_destroy();
header('location: index.php');
