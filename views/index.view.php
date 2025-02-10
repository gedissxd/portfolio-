<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-300">


  <div class="w-full max-w-2xl mx-auto mt-10 bg-white p-4 rounded-md sm:p-6 md:p-8">
    <h1 class="font-bold text-3xl flex justify-center items-center mb-5">
      Leave a comment
    </h1>
    <?php require "components/form-input.php" ?>
  </div>

  <div>
    <h1 class="text-2xl w-2xl mx-auto mt-12"><?php echo count($commentList); ?> Comments</h1>
  </div>

  <?php foreach ($commentList as $comment): ?>
    <?php if (!$comment['parent_id']): ?>
      <div class="mt-3 mb-5 w-full max-w-2xl mx-auto">
        <div class="hover:scale-102 duration-200 ease-in-out">
          <?php require "components/comment.php"; ?>
        </div>
        <?php
        $replies = array_filter($commentList, function ($reply) use ($comment) {
          return $reply['parent_id'] == $comment['id'];
        });
        foreach ($replies as $reply):
          ?>
          <div class="ml-8 mt-8 bg-white rounded-md hover:scale-102 duration-300 ease-in-out sm:ml-0">
            <?php $comment = $reply;
            require "components/comment.php"; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>

</body>

</html>