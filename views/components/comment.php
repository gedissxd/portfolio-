<div class="p-4 rounded-lg space-y-4 bg-white">
  <div class="flex justify-between">
    <div class="flex">
      <div class="font-bold mr-2"><?= $comment['name']; ?></div>
      <div><?php echo date('d M Y', strtotime($comment['created_at'])); ?></div>
    </div>
    <?php if (!isset($comment['parent_id']) || $comment['parent_id'] == 0): ?>
      <div class="flex items-center cursor-pointer" onclick="showReplyForm(<?php echo $comment['id']; ?>)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="size-6 mr-1">
          <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
        </svg>
        <span>Reply</span>
      </div>
    <?php endif; ?>
  </div>
  <div class="mt-2">
    <h2><?php echo $comment['comment']; ?></h2>
  </div>

  <div id="replyForm <?= $comment['id']; ?>" class="hidden mt-4">
    <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
    <?php require "views/components/form-input.php" ?>
  </div>
</div>


<script>
  function showReplyForm(commentId) {
    const formElement = document.getElementById('replyForm' + commentId);
    formElement.classList.toggle('hidden');
  }
</script>