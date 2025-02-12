<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../Reminders.php';

$db = new Database();
$conn = $db->getConnection();

$salt = "543dsf564hgf564|$54vf54dsf54!!4fdf";

$reminder = new Reminder($db);
$reminderList = $reminder->getAllReminders();

