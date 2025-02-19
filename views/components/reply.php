<div class="mr-8 mt-3 text-white rounded-md bg-[#121212] hover:scale-102 duration-300 ease-in-out sm:mr-0 max-w-xl ml-auto border border-[#2e2e2e]" data-reply-id="<?= $reply['id']; ?>" data-parent-id="<?= $reply['parent_id']; ?>">
    <div class="p-4 rounded-lg space-y-4">
        <div class="flex justify-between">
            <div class="flex">
                <div class="font-bold mr-2"><?= $reply['name']; ?></div>
                <div><?php echo date("F j, Y, g:i a", strtotime($reply['created_at'])); ?></div>
            </div>
        </div>
        <div class="mt-2">
            <h2 class="break-words whitespace-normal overflow-wrap-anywhere"><?php echo $reply['comment']; ?></h2>
        </div>
    </div>
</div>