<?php

include 'config.php';

$goals = $pronunciation = $deliverable = $deliverable_date = "";
$goals_err = $pronunciation_err = $deliverable_err = $deliverable_date_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["goals"]))) {
        $goals_err = "Παρακαλώ εισάγετε τους στόχους της εργασίας.";
    } else {
        $goals = trim($_POST["goals"]);
    }

    if (empty(trim($_POST["pronunciation"]))) {
        $pronunciation_err = "Παρακαλώ εισάγεται το όνομα/θέση εργασίας.";
    } else {
        $pronunciation = trim($_POST["pronunciation"]);
    }

    if (empty(trim($_POST["deliverable"]))) {
        $deliverable_err = "Παρακαλώ τα παραδοτέα της εργασίας.";
    } else {
        $deliverable = trim($_POST["deliverable"]);
    }

    if (empty(trim($_POST["deliverable_date"]))) {
        $deliverable_date_err = "Παρακαλώ την ημερομηνία παράδοσης της εργασίας.";
    } else {
        $deliverable_date = trim($_POST["deliverable_date"]);
    }

    if (empty($goals_err) && empty($pronunciation_err) && empty($deliverable_err) && empty($deliverable_date_err)) {

        $sql = "INSERT INTO projects (goals, pronunciation, deliverable, deliverable_date) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_goals, $param_pronunciation, $param_deliverable, $param_deliverable_date);

            $param_goals = $goals;
            $param_pronunciation = $pronunciation;
            $param_deliverable = $deliverable;
            $param_deliverable_date = $deliverable_date;

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

    <title>Προσθήκη </title>

    <style>
        <?php
        include "css/addAnnouncement.css";
        ?>
    </style>
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <h2>Προσθήκη Εργασίας</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Στόχοι Εργασίας</label>
                    <textarea type="text" name="goals" placeholder="Στόχοι..." <?php echo (!empty($goals_err)) ? 'is-invalid' : ''; ?> value="<?php echo $goals; ?>"></textarea>
                    <span><?php echo $goals_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Όνομα/Θέση Εργασίας</label>
                    <textarea type="text" name="pronunciation" placeholder="Όνομα/Θέση αρχείου..." <?php echo (!empty($pronunciation_err)) ? 'is-invalid' : ''; ?>></textarea>
                    <span><?php echo $pronunciation_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Παραδοτέα</label>
                    <textarea type="text" name="deliverable" placeholder="Παραδοτέα..." <?php echo (!empty($deliverable_err)) ? 'is-invalid' : ''; ?> value="<?php echo $deliverable; ?>"></textarea>
                    <span><?php echo $deliverable_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Ημερομηνία Παράδοσης</label>
                    <input type="text" name="deliverable_date" placeholder="Ημερομηνία παράδοσης..." <?php echo (!empty($deliverable_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $deliverable_date; ?>">
                    <span><?php echo $deliverable_date_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Προσθήκη">
                    <a href="homework.php">Άκυρο</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>