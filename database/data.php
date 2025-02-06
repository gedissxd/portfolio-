<?php

$sql = "SELECT * FROM komentaras";
$result = mysqli_query($conn, $sql);
$commentList = mysqli_fetch_all($result, MYSQLI_ASSOC);