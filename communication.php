<?php

session_start();

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // $sender = $_POST["sender"];
    // $subject = $_POST["subject"];
    // $message = $_POST["message"];

    // $recipient = "rafnikokavouras@gmail.com";

    // $mailHeaders = "Name: " . $sender . "\r\n Subject: " . $subject . "\r\n Message: " . $message . "\r\n";


    // if (mail($recipient, $subject, $message)) {
    //     echo "Το μήνυμα σας στάλθηκε επιτυχώς.";
    // } else {
    //     echo "Το μήνυμα σας δεν στάλθηκε.";
    // }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Home Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Επικοινωνία</title>

    <style>
        <?php
        include "css/communication.css";
        ?>
    </style>

    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">
</head>

<body>
    <section class="basic-section">
        <div class="header-div">
            <h1>Επικοινωνία</h1>
            <i onclick="myFunction()" id="menu-icon-i" class="fas fa-bars"></i>
        </div>

        <div class="hero-nav-div">
            <div class="container">
                <div class="nav-div" id="IDnav-div">
                    <ul>
                        <li><b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></li>
                        <li><a href="index.php">Αρχική</a></li>
                        <li><a href="communication.php">Επικοινωνία</a></li>
                        <li> <a href="reset-password.php">Αλλαγή Κωδικού</a></li>
                        <li><a href="logout.php">Αποσύνδεση</a></li>
                    </ul>
                </div>

                <div class="hero-div">
                    <h3>Αποστολή email μέσω web φόρμας</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="sender">Αποστολέας:</label>
                        <input name="sender" type="text" placeholder="<?php echo htmlspecialchars($_SESSION["email"]); ?>">
                        <label for="subject">Θέμα:</label>
                        <input name="subject" type="text">
                        <label for="textarea">Μήνυμα:</label>
                        <textarea name="message" type="text" placeholder="Γράψτε το μήνυμα σας..."></textarea>
                        <input type="submit" value="Αποστολή">
                    </form>

                    <h3>Αποστολή email με χρήση email διεύθυνσης</h3>
                    <ul>
                        <li>Εναλλακτικά μπορείτε να αποστείλετε e-mail στην παρακάτω διεύθυνση ηλεκτρονικού ταχυδρομείου
                            <a href="mailto: rafnikokavouras@gmail.com">rafnikokavouras@gmail.com<a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </section>

    <button class="scrollToTopBtn">☝️</button>
    <script src="js/index.js"></script>
</body>

</html>