<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <title>Comments</title>
  <link rel="icon"
    href="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/A_black_image.jpg/1200px-A_black_image.jpg"
    type="image/x-icon" />

</head>

<body class="bg-[#0f0f0f]">
  <?php require "components/nav.php" ?>
  <div class="pt-30 bg-[#121212]">
    <h1 class="text-white flex justify-center items-center text-3xl mt-5 font-bold">Hi welcome to the page!</h1>
    <h1 class="text-white flex justify-center items-center text-2xl font-bold">My name is Gediminas</h1>
    <div class="mt-200">
      <?php require "components/devider.php" ?>
    </div>
  </div>

  <div
    class="z-1 relative -mt-[150px] mx-auto max-w-[500px] border border-[#2e2e2e] bg-[#121212] rounded-md md:ml-[800px] sm:ml-[800px] p-5">
    <h2 class="text-white flex justify-center items-center mb-10 text-xl font-bold mt-5 sm:text-2xl">
      Tools that I use to build my projects
    </h2>

    <div class="grid grid-cols-5  justify-items-center items-center">
      <?php require "components/techstack.php"; ?>
    </div>

  </div>

  <div>
    <h1 class="text-white text-2xl font-bold flex justify-center items-center mt-10 duration-200 easy-in-out">
      Projects that i made</h1>
    <div class="grid grid-cols-1 gap-5 mt-10  lg:grid-cols-2 sm:mx-auto p-10 duration-500 easy-in-out ">
      <?php require "components/projects.php"; ?>
    </div>

  </div>
  <div>
    <div class="p-4">
      <div
        class="w-full max-w-2xl mx-auto mt-20 bg-[#121212]  border border-[#2e2e2e] text-white p-6 rounded-md sm:p-6 md:p-8 duration-200 easy-in-out">

        <h1 class="font-bold text-3xl flex justify-center items-center mb-3">
          Leave a comment
        </h1>

        <?php require "components/form-input.php" ?>
      </div>
    </div>


    <div>
      <h1 class="text-2xl max-w-2xl sm:mx-auto mt-5 mb-5 text-white md:px-0 px-3" id="comment-count">
        <?php echo $pagination['total_items']; ?> Comments
      </h1>
    </div>

    <div id="comments-container" class="mt-3 space-y-4 w-full max-w-2xl mx-auto md:px-0 px-3">
      <?php foreach ($commentList as $comment): ?>
        <?php if (!$comment['parent_id']): ?>
          <div>
            <?php
            $replies = array_filter($commentList, function ($reply) use ($comment) {
              return $reply['parent_id'] === $comment['id'];
            });
            require "components/comment.php";
            ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <div class="pagination-container">
      <?php require "components/pagination.php"; ?>
    </div>

    <footer class=" mt-10 border-t w-full  max-w-6xl mx-auto border-[#2e2e2e] flex justify-center items-center p-4">
      <a href="https://github.com/gedissxd" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white hover:scale-105 transition-transform"
          viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round">
          <path
            d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4" />
          <path d="M9 18c-4.51 2-5-2-7-2" />
        </svg>
      </a>
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
        error: function (xhr, status, error) {
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

    // Add AJAX pagination handling
    $(document).on('click', '.pagination-btn', function (e) {
      e.preventDefault();
      const page = $(this).data('page');
      const paginationContainer = $('.pagination-container');

      // Store the current position of the pagination buttons
      const paginationPosition = paginationContainer.offset().top;

      $.ajax({
        type: 'POST',
        url: 'index.php',
        data: {
          action: 'get_page',
          page: page
        },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Update comments
            $("#comments-container").html(response.commentsHtml);

            // Update pagination
            $(".pagination-container").html(response.paginationHtml);

            // Update comment count if needed
            $("#comment-count").text(response.totalItems + " Comments");

            // Scroll back to the pagination buttons position
            $('html, body').animate({
              scrollTop: paginationPosition
            }, 0);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
        },
      });
    });
  });
</script>