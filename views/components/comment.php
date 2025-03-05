<div class="comment-container">
  <div class="p-4 rounded-lg space-y-4 bg-[#121212] border border-[#2e2e2e] text-[#fafafa]  duration-200  ease-in-out"
    data-comment-id="<?= $comment['id']; ?>">
    <div class="flex justify-between">
      <div class="flex">
        <div class="font-bold mr-2 "><?= $comment['name']; ?></div>
        <div><?php echo date("F j, Y, g:i a", strtotime($comment['created_at'])); ?></div>
      </div>
      <?php if (!isset($comment['parent_id']) || $comment['parent_id'] == 0): ?>
        <div class="flex items-center cursor-pointer  duration-200 hover:scale-105 ease-in"
          onclick="showReplyForm(<?php echo $comment['id']; ?>)">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
          </svg>
          <span>Reply</span>
        </div>
      <?php endif; ?>
    </div>
    <div class="mt-2">
      <h2 class="break-words whitespace-normal overflow-wrap-anywhere"><?php echo $comment['comment']; ?></h2>
    </div>

    <div id="replyForm<?= $comment['id']; ?>" class="hidden mt-4">
      <form method="POST" class="commentForm rounded-md" action="index.php">
        <div class="flex flex-col space-y-4">
          <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex flex-col flex-1">
              <label class="mb-1">Email*</label>
              <input class="border border-[#2e2e2e] rounded-md p-2 w-full" maxlength="30" type="text" name="email"
                required>
            </div>
            <div class="flex flex-col flex-1">
              <label class="mb-1">Name*</label>
              <input class="border border-[#2e2e2e] rounded-md p-2 w-full" maxlength="30" type="text" name="name"
                required>
            </div>
          </div>

          <div class="flex flex-col">
            <label class="mb-1">Comment*</label>
            <textarea class="border border-[#2e2e2e] h-32 rounded-md p-2 w-full resize-none" name="comment" required
              maxlength="292"></textarea>
          </div>

          <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">

          <div class="flex justify-start">
            <input
              class="px-4 py-2 rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e] cursor-pointer duration-200 ease-in-out"
              type="submit" value="Submit">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="replies-container space-y-4" data-parent-id="<?= $comment['id']; ?>">
    <?php if (isset($replies)): ?>
      <?php foreach ($replies as $reply): ?>
        <?php require "views/components/reply.php"; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<script>
  function showReplyForm(commentId) {
    const formElement = document.getElementById('replyForm' + commentId);
    formElement.classList.toggle('hidden');
  }
</script>