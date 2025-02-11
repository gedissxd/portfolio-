<?php
require_once __DIR__ . '/../Database.php';

$db = new Database();
$conn = $db->getConnection();

$salt = "543dsf564hgf564|$54vf54dsf54!!4fdf";

if (isset($_SESSION['logged']) && isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM `personreminder` WHERE personID = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $reminderList = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $reminderList = array();
}
