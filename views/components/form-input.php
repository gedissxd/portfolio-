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

        <?php if (isset($comment['id'])): ?>
            <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
        <?php endif; ?>

        <div class="flex justify-start">
            <input
                class=" px-4 py-2 rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e] cursor-pointer hover:scale-105 duration-200 ease-in-out"
                type="submit" value="Submit">
        </div>
    </div>
</form>

<?php if (isset($error)): ?>
    <div class="text-red-600 mb-2"><?php echo $error; ?></div>
<?php endif; ?>