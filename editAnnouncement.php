<?php

include "config.php";

$id = $_GET["id"];
$query = mysqli_query($link, "SELECT * FROM announcements where id = '$id'");
$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Επεξεργασία Ανακοίνωσης</title>

    <style>
        <?php
        include "css/addAnnouncement.css";
        ?>
    </style>
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <h2>Επεξεργασία Ανακοίνωσης</h2>
            <form action="update.php?id=<?php echo $id; ?>" method="post">
                <div class="form-group">
                    <label>Θέμα Ανακοίνωσης</label>
                    <input type="text" name="project" value="<?php echo $row['project']; ?>">
                </div>
                <div class="form-group">
                    <label>Κείμενο Ανακοίνωσης</label>
                    <textarea type="text" name="maintext" placeholder="Γράψτε το νέο σας κείμενο..."></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Υποβολή">
                    <a href="announcement.php">Άκυρο</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>