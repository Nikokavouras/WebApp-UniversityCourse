<?php

include 'config.php';

$title = $description = $name_position_file = "";
$title_err = $description_err = $name_position_file_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["title"]))) {
        $title_err = "Παρακαλώ εισάγετε τον τίτλο του εγγράφου.";
    } else {
        $sql = "SELECT id FROM announcements WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_title);

            $param_title = trim($_POST["title"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $title_err = "Αυτός ο τίτλος υπάρχει ήδη.";
                } else {
                    $title = trim($_POST["title"]);
                }
            } else {
                echo "Ουπς! Κάτι δεν πήγε καλά. Παρακαλώ δοκιμάστε αργότερα.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["description"]))) {
        $description_err = "Παρακαλώ εισάγεται την περιγραφή του εγγράφου.";
    } else {
        $description = trim($_POST["description"]);
    }

    if (empty(trim($_POST["name_position_file"]))) {
        $name_position_file_err = "Παρακαλώ εισάγεται το όνομα/θέση του εγγράφου.";
    } else {
        $name_position_file = trim($_POST["name_position_file"]);
    }

    if (empty($title_err) && empty($description_err) && empty($name_position_file_err)) {

        $sql = "INSERT INTO documents (title, description, name_position_file) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_description, $param_name_position_file);

            $param_title = $title;
            $param_description = $description;
            $param_name_position_file = $name_position_file;

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

    <title>Προσθήκη Εγγράφου</title>

    <style>
        <?php
        include "css/addAnnouncement.css";
        ?>
    </style>
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <h2>Προσθήκη Εγγράφου</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Τίτλος Εγγράφου</label>
                    <input type="text" name="title" placeholder="Γράψτε τον τίτλο του εγγράφου... <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                    <span><?php echo $title_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Περιγραφή Εγγράφου</label>
                    <textarea type="text" name="description" placeholder="Γράψτε την περιγραφή του εγγράφου..." <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"></textarea>
                    <span><?php echo $description_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Όνομα/Θέση Εγγράφου</label>
                    <input type="text" name="name_position_file" placeholder="Γράψτε το όνομα/θέση του εγγράφου..." <?php echo (!empty($name_position_file_err)) ? 'is-invalid' : ''; ?>">
                    <span><?php echo $name_position_file_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Προσθήκη">
                    <a href="documents.php">Άκυρο</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>