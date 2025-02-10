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

        <?php if (isset($comment['id'])): ?>
            <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
        <?php endif; ?>

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

        // Clear any existing error messages
        const existingError = form.querySelector('.text-red-600');
        if (existingError) {
            existingError.remove();
        }

        // Send the data to PHP
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // This line refreshes the page
                    window.location.reload();
                } else {
                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-red-600 mb-2';
                    errorDiv.textContent = data.message;
                    form.appendChild(errorDiv);
                }
            })

    }
</script>