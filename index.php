<?php
require "database/db.php";
require "database/data.php";
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    $name = test_input($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $comment = test_input($_POST["comment"]);
    $parent_id = isset($_POST["parent_id"]) ? $_POST["parent_id"] : NULL;

    if ($email === false) {
        $response['status'] = 'error';
        $response['message'] = "Please enter a valid email address";
    } elseif (empty($name)) {
        $response['status'] = 'error';
        $response['message'] = "Please enter a valid name";
    } elseif (empty($comment)) {
        $response['status'] = 'error';
        $response['message'] = "Please enter a valid comment";
    } else {
        $sql = "INSERT INTO komentaras (name, email, comment, parent_id) 
        VALUES ('$name', '$email', '$comment', " . ($parent_id ? "'$parent_id'" : "NULL") . ")";
        $result = mysqli_query($conn, $sql);

        $response['status'] = 'success';
        $response['message'] = 'Comment added successfully';
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

require "views/index.view.php";