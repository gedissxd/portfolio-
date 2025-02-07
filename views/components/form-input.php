<form method="POST" class="rounded-md" action="index.php" onsubmit="submitForm(event)">
    <div class="flex flex-col space-y-4">
        <div class="flex justify-between w-full">
            <div class="flex mr-4">
                <label class="mb-1 p-2">Email*</label>
                <input class="border border-gray-400 rounded-md p-2" type="text" name="email" required>
            </div>
            <div class="flex ">
                <label class="mb-1 p-2">Name*</label>
                <input class="border border-gray-400 rounded-md p-2" type="text" name="name" required>
            </div>
        </div>

        <div class="">
            <label class="mb-1">Comment*</label>
            <textarea class="border border-gray-400 h-32 rounded-md p-2 w-full" name="comment" required></textarea>
        </div>

        <div class="flex justify-start">
            <input class="bg-gray-400 px-4 py-2 rounded-md hover:bg-gray-600 cursor-pointer" type="submit"
                value="Submit">
        </div>
    </div>
</form>

<?php if (isset($error)): ?>
    <div class="text-red-600 mb-2"><?php echo $error; ?></div>
<?php endif; ?>

<script>
    function submitForm(event) {
        // Stop the normal form submission
        event.preventDefault();

        // Get the form data and send it
        const form = event.target;
        const formData = new FormData(form);

        // Send the data to PHP
        fetch('index.php', {
            method: 'POST',
            body: formData
        })
            // After PHP saves the comment, reload the page
            .then(function () {
                // This line refreshes the page
                window.location.reload();
            });
    }
</script>