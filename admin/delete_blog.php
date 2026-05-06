<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$conn->query("DELETE FROM blogs WHERE id=$id");

header("Location: dashboard.php");
?>