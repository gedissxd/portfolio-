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
<form  method="POST" class="mx-auto w-2xl mt-5 bg-gray-400">

 <div class="flex justify-between">
 <label class="p-2">Email*</label> <input class="bg-red-300 rounded-md p-2" type="text" name="name">
 <label class="p-2">Name*</label> <input class="bg-red-300 rounded-md p-2" type="text" name="email">
 </div>

<div class="flex mt-3">
    <label class="p-2 mr-5 mt-7">Comment*</label>
    <textarea class="bg-red-300 h-32 w-full rounded-md" type="text" name="comment"></textarea>
</div>
<input class="bg-gray-700 px-3 py-1 rounded-md mt-3 ml-28" type="submit">




</form>
</body>
</html>