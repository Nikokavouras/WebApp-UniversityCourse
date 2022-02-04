<?php
include 'config.php';

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Παρακαλώ εισάγετε το email.";
    } else {
        if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Η είσοδος που δώσατε δέν έχει την μορφή email.";
        } else
            $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Παρακαλώ εισάγετε τον κωδικό.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            header("location: index.php");
                        } else {
                            $login_err = "Λανθασμένο email ή κωδικός.";
                        }
                    }
                } else {
                    $login_err = "Λανθασμένο email ή κωδικός.";
                }
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
    <meta charset="UTF-8">

    <title>Σύνδεση</title>

    <style>
        <?php
        include "css/login.css";
        ?>
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <h2>Σύνδεση</h2>
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
                <span><?php echo $login_err; ?></span>
                <div class="form-group">
                    <input type="submit" value="Σύνδεση">
                </div>
                <p>Δεν έχετε λογαριασμό; <a href="register.php">Πατήστε εδώ.</a></p>
            </form>
        </div>
    </div>
</body>

</html>