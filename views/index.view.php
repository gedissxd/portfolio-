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

<body
  class="absolute top-0 z-[-2] h-screen w-screen bg-[#000000] bg-[radial-gradient(#ffffff33_1px,#00091d_1px)] bg-[size:20px_20px]">

  <div class="bg-gray-400 h-12  max-w-4xl mx-auto mt-4 rounded-full border border-white sm:max-w-4xl">
    <nav class="flex justify-center items-center text-white font-bold text-1xl h-full w-full">
      <a href="index.php">Home</a>
    </nav>
  </div>

  <div class="w-full max-w-2xl mx-auto mt-10 bg-white p-4 rounded-md sm:p-6 md:p-8">

    <h1 class="font-bold text-3xl flex justify-center items-center mb-3">
      Leave a comment
    </h1>

    <?php require "components/form-input.php" ?>
  </div>

  <div>
    <h1 class="text-2xl max-w-2xl mx-auto mt-5 mb-5" id="comment-count"><?php echo count($commentList); ?> Comments</h1>
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

<footer class="bg-gray-400 h-30 mt-5 border-t border-white">
</footer>

</html>

<script>
  $(document).ready(function () {
    $(document).on('submit', '.commentForm', function (e) {
      e.preventDefault();

      const form = $(this);
      const submitButton = form.find('input[type="submit"]');
      const formData = form.serialize();

      // Disable submit button while processing
      submitButton.prop('disabled', true);

      $.ajax({
        type: 'POST',
        url: 'index.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $("#comment-count").text(response.commentCount + " Comments");

            // Show success message without reloading the page
            const successDiv = $('<div>')
              .addClass('text-green-600 mb-2')
              .text(response.message);
            form.prepend(successDiv);

            // Clear the form inputs
            form[0].reset();

            // Dynamically insert the new comment HTML:
            if (response.isReply) {
              // Find the parent comment and append the reply after it
              const parentComment = $("#comments-container").find(`[data-comment-id="${response.parentId}"]`).closest('.hover\\:scale-102');
              $(response.commentHtml).insertAfter(parentComment);
              // Hide the reply form after successful submission
              $(`#replyForm${response.parentId}`).addClass('hidden');
            } else {
              // For top-level comments, prepend to the main comments container.
              $("#comments-container").prepend(response.commentHtml);
            }

            // Remove success message after 3 seconds (optional)
            setTimeout(() => {
              successDiv.fadeOut(() => successDiv.remove());
            }, 3000);
          } else {
            // Show error message in the form
            const errorDiv = $('<div>')
              .addClass('text-red-600 mb-2')
              .text(response.error);
            form.prepend(errorDiv);

            // Remove error message after 3 seconds
            setTimeout(() => {
              errorDiv.fadeOut(() => errorDiv.remove());
            }, 3000);
          }
        },
        error: function (xhr, status, error) {
          const errorDiv = $('<div>')
            .addClass('text-red-600 mb-2')
            .text('An error occurred while submitting the comment. Please try again.');
          form.prepend(errorDiv);
        },
        complete: function () {
          // Re-enable submit button
          submitButton.prop('disabled', false);
        }
      });
    });
  });
</script>