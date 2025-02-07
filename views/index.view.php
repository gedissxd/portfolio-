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
  <div class="w-2xl mx-auto mt-10">

    <?php require "components/form-input.php" ?>
  </div>

  <div>
    <h1 class="text-2xl w-2xl mx-auto mt-12"><?php echo count($commentList); ?> Comments</h1>
  </div>

  <?php foreach ($commentList as $comment): ?>
    <?php if (!$comment['parent_id']): ?>
      <div class="mt-3 mb-5 w-2xl mx-auto p-4">
        <?php
        require "components/comment.php";
        $replies = array_filter($commentList, function ($reply) use ($comment) {
          return $reply['parent_id'] == $comment['id'];
        });
        foreach ($replies as $reply):
          ?>
          <div class="ml-8 mt-8 bg-white rounded-md">
            <?php $comment = $reply;
            require "components/comment.php"; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>

</body>

</html>