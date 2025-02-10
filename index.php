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
        $response = ['success' => false, 'error' => "Invalid email address"];
    } elseif (empty($data['name'])) {
        $response = ['success' => false, 'error' => "Name is required"];
    } elseif (empty($data['comment'])) {
        $response = ['success' => false, 'error' => "Comment is required"];
    } else {
        if ($comments->saveComment($data)) {
            // Retrieve the newly inserted comment using the insert_id
            $lastId = $db->getConnection()->insert_id;
            $result = $db->getConnection()->query("SELECT * FROM komentaras WHERE id = {$lastId}");
            $newComment = $result->fetch_assoc();

            // Render the comment HTML using your components:
            if (!$newComment['parent_id'] || $newComment['parent_id'] == 0) {
                ob_start();
                $comment = $newComment;
                require "views/components/comment.php";
                $commentHtml = ob_get_clean();
                $isReply = false;
                $parentId = null;
            } else {
                ob_start();
                $reply = $newComment;
                require "views/components/reply.php";
                $commentHtml = ob_get_clean();
                $isReply = true;
                $parentId = $newComment['parent_id'];
            }

            // Query for new comment count
            $countResult = $db->getConnection()->query("SELECT COUNT(*) as count FROM komentaras");
            $countRow = $countResult->fetch_assoc();
            $commentCount = $countRow['count'];

            $response = [
                'success' => true,
                'message' => "Comment saved successfully!",
                'commentHtml' => $commentHtml,
                'isReply' => $isReply,
                'parentId' => $parentId,
                'commentCount' => $commentCount
            ];
        } else {
            $response = ['success' => false, 'error' => "Error saving comment."];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$commentList = $comments->getAllComments();
require "views/index.view.php";