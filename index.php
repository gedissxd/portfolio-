<?php
require "Database.php";
require "Comment.php";

$db = new Database();
$comments = new Comment($db);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = [];

    $data = [
        'name' => test_input($_POST["name"]),
        'email' => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
        'comment' => test_input($_POST["comment"]),
        'parent_id' => $_POST["parent_id"] ?? null
    ];

    if (!$data['email']) {
        $error = "Invalid email address";
    } elseif (empty($data['name'])) {
        $error = "Name is required";
    } elseif (empty($data['comment'])) {
        $error = "Comment is required";
    } else {
        $comments->saveComment($data);
        $response['success'] = "Comment added successfully";
    }
}

$commentList = $comments->getAllComments();
require "views/index.view.php";