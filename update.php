<?php

include "config.php";

$id = $_GET['id'];

$project = $_POST["project"];
$maintext = $_POST["maintext"];

mysqli_query($link, "UPDATE announcements set project = '$project', maintext = '$maintext' where id='$id'");
header('location: announcement.php');
