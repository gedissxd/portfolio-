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

    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $comment = test_input($_POST["comment"]);

    $sql = "INSERT INTO komentaras (name, email, comment) 
    VALUES ('$name', '$email', '$comment')";
    $result = mysqli_query($conn, $sql);

}

require "views/index.view.php";