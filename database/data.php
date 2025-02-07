<?php

$sql = "SELECT * FROM komentaras ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$commentList = mysqli_fetch_all($result, MYSQLI_ASSOC);