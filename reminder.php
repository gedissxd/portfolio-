<?php
session_start();


$userId = 1;

require_once 'database/data.php';
require_once 'functions.php';



$activeReminders = [];
$archivedReminders = [];

if (isset($_GET['sort']) && $_GET['sort'] === 'closest') {
    usort($reminderList, function ($a, $b) {
        return strtotime($a['personDate']) - strtotime($b['personDate']);
    });
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminders</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#0f0f0f]">
    <?php require "views/components/nav.php"; ?>
    <div class="p-4">
        <div class="flex space-x-2">
            <a href="remindercreate.php">
                <button
                    class=" px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e] cursor-pointer hover:scale-105 duration-200 ease-in-out">
                    Create Reminder
                </button>
            </a>
            <form method="GET" action="reminder.php" class="">
                <button type="submit" name="sort" value="closest"
                    class=" px-4 py-2 text-white rounded-md hover:bg-[#1f1f1f] border border-[#2e2e2e] cursor-pointer hover:scale-105 duration-200 ease-in-out">
                    Sort by Closest
                </button>
            </form>
        </div>


        <div class="grid sm:grid-cols-3 grid-cols-2 gap-2 mt-4 mx-auto">
            <?php

            foreach ($reminderList as $reminder) {
                if ($reminder['personID'] == $userId) {
                    $reminderDate = $reminder['personDate'];
                    $todayDate = date('Y-m-d');

                    if ($reminderDate < $todayDate) {
                        $archivedReminders[] = $reminder;
                    } else {
                        $activeReminders[] = $reminder;
                    }
                }
            }

            ?>
            <?php foreach ($activeReminders as $reminder): ?>
                <?php if ($reminder['personID'] == $userId): ?>
                    <?php
                    $reminderDate = $reminder['personDate'];
                    $todayDate = date('Y-m-d');

                    $earlier = new DateTime("$todayDate");
                    $later = new DateTime("$reminderDate");


                    ?>
                    <div class="bg-[#121212]  text-white p-4 rounded-lg border border-[#2e2e2e]">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="reminderedit.php?id=<?= $reminder['personReminderID'] ?>">
                                <button
                                    class=" font-bold border border-[#2e2e2e] px-2 py-1 rounded cursor-pointer hover:bg-[#1f1f1f] hover:scale-105 duration-200 ease-in-out">
                                    EDIT
                                </button>
                            </a>
                            <a href="reminderdelete.php?id=<?= $reminder['personReminderID'] ?>">
                                <button
                                    class=" font-bold border border-[#2e2e2e] px-2 py-1 rounded cursor-pointer hover:bg-[#1f1f1f] hover:scale-105 duration-200 ease-in-out">
                                    DELETE
                                </button>
                            </a>
                        </div>
                        <p class="text-lg font-semibold mt-2 break-words whitespace-normal overflow-wrap-anywhere">
                            <?= $reminder['personReminder'] ?>
                        </p>
                        <div class="text-sm  mt-2 font-bold">
                            <?= date('Y-m-d', strtotime($reminder['personDate'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
        <h2 class="mt-8 text-xl font-bold text-white">Archived Reminders</h2>
        <div class="grid grid-cols-3 gap-4 mt-4 mx-auto">
            <?php foreach ($archivedReminders as $reminder): ?>
                <div class="bg-[#121212] h-fit md:break-after-auto text-white p-4 rounded-lg border border-[#2e2e2e]">
                    <p class="text-lg font-semibold">
                        <?= $reminder['personReminder'] ?>
                    </p>
                    <div class="text-sm mt-2 font-bold">
                        <?= $reminder['personDate'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


</body>

</html>