<?php

include 'config.php';

$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Παρακαλώ εισάγετε το email σας.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Η είσοδος που δώσατε δέν έχει την μορφή email.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST["email"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Το email που δώσατε υπάρχει ήδη.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Ουπς! Κάτι δεν πήγε καλά. Παρακαλώ δοκιμάστε αργότερα.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Παρακαλώ εισάγεται τον κωδικό.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Ο κωδικός θα πρέπει να περιέχει τουλάχιστον 6 χαρακτήρες.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Παρακαλώ επιβεβαιώστε τον κωδικό.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Παρακαλώ επιβεβαιώστε τον κωδικό.";
        }
    }

    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

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

    <title>Εγγραφή</title>

    <style>
        <?php
        include "css/register.css";
        ?>
    </style>
</head>

<body>
    <section class="wrapper">
        <div class="container">
            <h2>Εγγραφή</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Κωδικός</label>
                    <input type="password" name="password" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Eπιβεβαιώση κωδικού</label>
                    <input type="password" name="confirm_password" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span><?php echo $confirm_password_err; ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" value="Εγγραφή">
                </div>
                <p>Άν έχετε λογαριασμό; <a href="login.php">Πατήστε εδώ.</a></p>
            </form>
        </div>
    </section>
</body>

</html>