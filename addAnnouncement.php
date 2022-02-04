<?php

include 'config.php';

$project = $maintext = "";
$project_err = $maintext_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["project"]))) {
        $project_err = "Παρακαλώ εισάγετε το θέμα της ανακοίνωσης.";
    } else {
        $sql = "SELECT id FROM announcements WHERE project = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_project);

            $param_project = trim($_POST["project"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $project_err = "Αυτό το θέμα υπάρχει ήδη.";
                } else {
                    $project = trim($_POST["project"]);
                }
            } else {
                echo "Ουπς! Κάτι δεν πήγε καλά. Παρακαλώ δοκιμάστε αργότερα.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["maintext"]))) {
        $maintext_err = "Παρακαλώ εισάγεται το κείμενο της ανακοίνωσης.";
    } else {
        $maintext = trim($_POST["maintext"]);
    }

    if (empty($project_err) && empty($maintext_err)) {

        $sql = "INSERT INTO announcements (project, maintext) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_project, $param_maintext);

            $param_project = $project;
            $param_maintext = $maintext;

            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Ουπς! Κάτι δεν πήγε καλά. Παρακαλώ δοκιμάστε αργότερα.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Home Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Προσθήκη Ανακοίνωσης</title>

    <style>
        <?php
        include "css/addAnnouncement.css";
        ?>
    </style>
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <h2>Προσθήκη Ανακοίνωσης</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Θέμα Ανακοίνωσης</label>
                    <input type="text" name="project" placeholder="Γράψτε το θέμα της ανακοίνωσης... <?php echo (!empty($project_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $project; ?>">
                    <span><?php echo $project_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Κείμενο Ανακοίνωσης</label>
                    <textarea type="text" name="maintext" placeholder="Γράψτε το κέιμενο της ανακοίνωσης..." <?php echo (!empty($maintext_err)) ? 'is-invalid' : ''; ?>"></textarea>
                    <span><?php echo $maintext_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Προσθήκη">
                    <a href="announcement.php">Άκυρο</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>