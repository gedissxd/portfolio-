<?php
session_start();


$userId = $_SESSION['user_id'];

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

<body class="bg-[#4C4E4F] overflow-y-scroll">
    <?php require "../views/components/nav.php"; ?>
    <div class="p-16">
        <div class="flex space-x-2">
            <a href="remindercreate.php">
                <button class="bg-[#89985B] hover:bg-[#89985B]/90 text-white font-bold py-2 px-4 rounded">
                    Create Reminder
                </button>
            </a>
            <form method="GET" action="reminder.php" class="">
                <button type="submit" name="sort" value="closest"
                    class="bg-[#89985B] hover:bg-[#89985B]/90 text-white font-bold py-2 px-4 rounded">
                    Sort by Closest
                </button>
            </form>
        </div>


        <div class="grid grid-cols-3 gap-4 mt-4 mx-auto ">
            <?php

            foreach ($reminderList as $reminder) {
                if ($reminder['personID'] == $_SESSION['user_id']) {
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
                <?php if ($reminder['personID'] == $_SESSION['user_id']): ?>
                    <?php
                    $reminderDate = $reminder['personDate'];
                    $todayDate = date('Y-m-d');

                    $earlier = new DateTime("$todayDate");
                    $later = new DateTime("$reminderDate");

                    $pos_diff = $earlier->diff($later)->format("%r%a");
                    $neg_diff = $later->diff($earlier)->format("%r%a");
                    if ($pos_diff == 0) {
                        $bgColor = 'bg-red-500';
                    } elseif ($pos_diff == 1) {
                        $bgColor = 'bg-yellow-500';
                    } elseif ($pos_diff == 2) {
                        $bgColor = 'bg-yellow-500';
                    } elseif ($neg_diff > 0) {
                        $bgColor = 'bg-red-500';
                    } else {
                        $bgColor = 'bg-[#89985B]';
                    }
                    ?>
                    <div class="<?= $bgColor ?>  text-white p-4 rounded-lg border-2">
                        <div class="flex flex-row gap-2">
                            <a href="reminderedit.php?id=<?= $reminder['personReminderID'] ?>">
                                <button class="text-blue-500 font-bold bg-gray-100 px-2 rounded">
                                    EDIT
                                </button>
                            </a>
                            <a href="reminderdelete.php?id=<?= $reminder['personReminderID'] ?>">
                                <button class="text-red-500 font-bold bg-gray-100 px-2 rounded">
                                    DELETE
                                </button>
                            </a>
                        </div>
                        <p class="text-lg font-semibold">
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
                <div class="bg-gray-500 text-white p-4 rounded-lg border-2">
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