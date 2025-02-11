<?php
session_start();

require_once 'database/data.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = "DELETE FROM personreminder WHERE personReminderID = $_GET[id]";
    $result = mysqli_query($conn, $sql);
    header('Location: reminder.php');
    exit();
} else {
    header('Location: reminder.php');
    exit();
}