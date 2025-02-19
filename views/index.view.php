<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <title>Comments</title>
  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 20px;
    }

    ::-webkit-scrollbar-track {
      background: #0f0f0f;
    }

    ::-webkit-scrollbar-thumb {
      background: #2e2e2e;
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #3e3e3e;
    }

    /* For Firefox */
    * {
      scrollbar-width: thin;
      scrollbar-color: #2e2e2e #0f0f0f;
    }
  </style>
</head>

<body class="bg-[#0f0f0f]">

  <?php require "components/nav.php" ?>

  <div class="h-[calc(100vh-64px)] overflow-y-auto" style="scrollbar-gutter: stable;">
    <div
      class="w-full max-w-2xl mx-auto mt-10 bg-[#121212]  border border-[#2e2e2e] text-white p-4 rounded-md sm:p-6 md:p-8">

      <h1 class="font-bold text-3xl flex justify-center items-center mb-3">
        Leave a comment
      </h1>

      <?php require "components/form-input.php" ?>
    </div>

    <div>
      <h1 class="text-2xl max-w-2xl mx-auto mt-5 mb-5 text-white" id="comment-count">
        <?php echo $pagination['total_items']; ?> Comments
      </h1>
    </div>

    <div id="comments-container" class="mt-3 space-y-4 w-full max-w-2xl mx-auto">
      <?php foreach ($commentList as $comment): ?>
        <?php if (!$comment['parent_id']): ?>
          <div>
            <?php 
            $replies = array_filter($commentList, function($reply) use ($comment) {
              return $reply['parent_id'] === $comment['id'];
            });
            require "components/comment.php"; 
            ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <div class="flex justify-center gap-2 my-8">
      <?php if ($pagination['has_previous']): ?>
        <a href="?page=<?= $page - 1 ?>"
          class="px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e]">
          Previous
        </a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
        <a href="?page=<?= $i ?>"
          class="px-4 py-2 text-white rounded-md <?= $i === $page ? 'bg-[#1f1f1f]' : 'hover:bg-[#1f1f1f]' ?> border border-[#2e2e2e]">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($pagination['has_next']): ?>
        <a href="?page=<?= $page + 1 ?>"
          class="px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e]">
          Next
        </a>
      <?php endif; ?>
    </div>

    <footer class="h-15 mt-10 border-t w-7xl mx-auto border-[#2e2e2e]">
    </footer>
  </div>

</body>

</html>

<script>
  $(document).ready(function () {
    $(document).on('submit', '.commentForm', function (e) {
      e.preventDefault();

      const form = $(this);
      const submitButton = form.find('input[type="submit"]');
      const formData = form.serialize();
      const parentId = form.find('input[name="parent_id"]').val();

      // Disable submit button while processing
      submitButton.prop('disabled', true);

      $.ajax({
        type: 'POST',
        url: 'index.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Update comment count
            $("#comment-count").text(response.commentCount + " Comments");

            // Show success message
            const successDiv = $('<div>')
              .addClass('text-green-600 mb-2')
              .text(response.message);
            form.prepend(successDiv);

            // Clear the form
            form[0].reset();

            if (response.isReply) {
              // Find the replies container for this parent comment
              const repliesContainer = $(`.replies-container[data-parent-id="${response.parentId}"]`);
              
              // Append the new reply to the replies container
              repliesContainer.append(response.commentHtml);
              
              // Hide the reply form
              $(`#replyForm${response.parentId}`).addClass('hidden');
            } else {
              // For new top-level comments, prepend to the comments container
              const commentHtml = $(response.commentHtml);
              $("#comments-container").prepend(commentHtml);
            }

            // Remove success message after 3 seconds
            setTimeout(() => {
              successDiv.fadeOut(() => successDiv.remove());
            }, 3000);
          } else {
            // Show error message
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
        error: function(xhr, status, error) {
          console.error("AJAX Error:", status, error);
          const errorDiv = $('<div>')
            .addClass('text-red-600 mb-2')
            .text('An error occurred while submitting your comment. Please try again.');
          form.prepend(errorDiv);

          setTimeout(() => {
            errorDiv.fadeOut(() => errorDiv.remove());
          }, 3000);
        },
        complete: function () {
          // Re-enable submit button
          submitButton.prop('disabled', false);
        }
      });
    });
  });
</script>

<?php
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 10; // Adjust this number as needed
$result = $comments->getCommentsByPage($page, $perPage);
$commentList = $result['comments'];
$pagination = $result['pagination'];
?>