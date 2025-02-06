<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
</head>
<body class="bg-gray-300">

<h1 class="font-bold text-3xl flex justify-center items-center mt-5">
  Leave a comment
</h1>
<?php require "components/form-input.php" ?>

<div>
  <h1 class="text-2xl w-2xl mx-auto mt-12">2 Comments</h1>
</div>


<div class="mb-5 w-2xl mx-auto bg-white rounded-md">
<?php require "components/comment.php"; ?>
</div>
<?php require "components/form-input.php" ?>
<div class="mb-5 w-2xl mx-auto bg-white rounded-md">
<?php require "components/comment.php"; ?>
</div>



</body>
</html>