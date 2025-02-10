<div class="mr-8 bg-white rounded-md hover:scale-102 duration-300 ease-in-out sm:mr-0 max-w-xl ml-auto">
    <div class="p-4 rounded-lg space-y-4 bg-white">
        <div class="flex justify-between">
            <div class="flex">
                <div class="font-bold mr-2"><?= $reply['name']; ?></div>
                <div><?php echo date('d M Y', strtotime($reply['created_at'])); ?></div>
            </div>
        </div>
        <div class="mt-2">
            <h2><?php echo $reply['comment']; ?></h2>
        </div>
    </div>
</div>