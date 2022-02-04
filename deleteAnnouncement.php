<?php
include 'config.php';
include 'announcement.php';

$id = $_GET['id'];

$del = mysqli_query($db, "DELETE FROM announcements where id = '$id'");

if (!$del)
    echo "Error deleting record";
