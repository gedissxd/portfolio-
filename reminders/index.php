<?php
session_start();
require_once "database/data.php";
require_once "functions.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#4C4E4F] mt-12 p-16 text-white">
    <h1 class="text-3xl font-bold">Welcome <?php
    foreach ($personList as $person)
        $user = $person['personName'];
    echo "$user" ?></h1>
</body>

</html>