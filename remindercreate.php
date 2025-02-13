<?php
session_start();

require_once 'database/data.php';
require_once 'functions.php';

$formErrors = [];
$formSubmitted = isset($_POST['submit']);
$message = "";
$date = "";
$userId = 1;
if ($formSubmitted) {
    if (isset($_POST['message']) && trim($_POST['message']) !== '') {
        $message = $_POST['message'];
    } else {
        $formErrors['message'] = 'message cannot be empty.';
    }
    if (isset($_POST['date']) && $_POST['date'] !== '') {
        $date = $_POST['date'];
    } else {
        $formErrors['date'] = 'Date cannot be empty.';
    }

    if (empty($formErrors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO personreminder (personReminder, personID, personDate) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $message, $userId, $date);
            if (!$stmt->execute()) {
                $formErrors['database'] = "Failed to create reminder: " . $stmt->error;
            }
            $stmt->close();
            mysqli_close($conn);
            if (empty($formErrors)) {
                header('Location: reminder.php');
                exit();
            }
        } catch (Exception $e) {
            $formErrors['database'] = "Error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reminder</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#0f0f0f]">
    <?php require "views/components/nav.php"; ?>
    <div class="flex justify-center items-center mt-10 p-10">
        <?php if (!$formSubmitted || !empty($formErrors)): ?>
            <form class="bg-[#121212]  border  border-[#2e2e2e] text-white rounded-2xl p-4 flex flex-col gap-4 w-[400px]"
                method="post">
                <h1 class="text-3xl font-bold">Create Reminder</h1>
                <div>
                    <textarea class="block w-full rounded-lg text-white border  border-[#2e2e2e] p-2 resize-none"
                        name="message" placeholder="Reminder"><?= $message; ?></textarea>
                    <?php if (isset($formErrors['message'])): ?>
                        <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['message']; ?></span>
                    <?php endif; ?>
                </div>

                <div>
                    <input class="block w-full rounded-lg text-white border  border-[#2e2e2e] p-2" type="date" name="date"
                        min="<?= date('Y-m-d') ?>" value="<?= $date; ?>" />
                    <?php if (isset($formErrors['date'])): ?>
                        <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['date']; ?></span>
                    <?php endif; ?>
                </div>

                <input type="submit" name="submit" value="Create"
                    class="border border-[#2e2e2e] block w-full rounded-lg  text-white hover:bg-[#1f1f1f] text-black p-2 cursor-pointer hover:scale-105 duration-200 ease-in-out">
            </form>
        <?php endif; ?>
    </div>

</body>

</html>