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
<form  method="POST" class="mx-auto w-2xl mt-10">

 <div class="flex justify-between">
 <label class="p-2">Email*</label> <input class="border-1 border-gray-400 rounded-md p-2" type="text" name="name">
 <label class="p-2">Name*</label> <input class="border-1 border-gray-400 rounded-md p-2" type="text" name="email">
 </div>

<div class="flex mt-3">
    <label class="p-2 mr-4 mt-7">Comment*</label>
    <textarea class="border-1 border-gray-400 h-32 w-full rounded-md" type="text" name="comment"></textarea>
</div>
<input class="bg-gray-400 px-4 py-2 rounded-md mt-3 ml-27" type="submit">




</form>
</body>
</html>