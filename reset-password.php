<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "demo";

$link = mysqli_connect($server_name, $username, $password, $db_name);

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Παρακαλώ εισάγετε τον νέο κωδικό.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Ο κωδικός πρέπει να έχει τουλάχιστον 6 χαρακτήρες.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Παρακαλώ επιβεβαιώστε τον κωδικό.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Οι κωδικός δεν επιβεβαιώθηκε.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            if (mysqli_stmt_execute($stmt)) {
                session_destroy();
                header("location: login.php");
                exit();
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

    <title>Αλλαγή Κωδικού</title>

    <link rel="stylesheet" href="css/reset-password.css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <h2>Αλλαγή Κωδικού</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Νέος Κωδικός</label>
                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Επιβεβαίωση Νέου Κωδικού</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Αλλαγή Κωδικού">
                    <a href="index.php">Άκυρο</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>