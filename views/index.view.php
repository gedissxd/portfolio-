<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

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


  <div id="comments-container" class="mt-3 space-y-4 w-full max-w-2xl mx-auto">
    <?php foreach ($commentList as $comment): ?>
      <?php if (!$comment['parent_id']): ?>
        <div class="hover:scale-102 duration-200 ease-in-out">
          <?php require "components/comment.php"; ?>
        </div>
        <?php
        $replies = [];
        foreach ($commentList as $reply) {
          if ($reply['parent_id'] === $comment['id']) {
            $replies[] = $reply;
          }
        }
        foreach ($replies as $reply):
          require "components/reply.php";
        endforeach; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

</body>

</html>