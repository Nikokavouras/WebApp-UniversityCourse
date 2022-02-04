<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Home Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Εργασίες</title>

    <style>
        <?php
        include "css/homework.css";
        ?>
    </style>
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">
</head>

<body>
    <section class="basic-section">
        <div class="header-div">
            <h1>Εργασίες</h1>
            <i onclick="myFunction()" id="menu-icon-i" class="fas fa-bars"></i>
        </div>
        <div class="hero-nav-div">
            <div class="container">
                <div class="nav-div" id="IDnav-div">
                    <ul>
                        <li><b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></li>
                        <li><a href="index.php">Αρχική</a></li>
                        <li><a href="announcement.php">Ανακοινώσεις</a></li>
                        <li><a href="homework.php">Εργασίες</a></li>
                        <li> <a href="reset-password.php">Αλλαγή Κωδικού</a></li>
                        <li><a href="logout.php">Αποσύνδεση</a></li>
                    </ul>
                </div>

                <div class="hero-div">
                    <?php
                    if ($_SESSION["email"] == "admin@gmail.com") {
                        echo "<div class='admin-div'><a href='addHomework.php'>Προσθήκη Εργασίας</a></div>";
                    }

                    $sqlPrint = "SELECT id, goals, pronunciation, deliverable, deliverable_date from projects";
                    $result = $link->query($sqlPrint);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $position = $row["pronunciation"];  // correct syndax for example "course documents/Εργασία 1.docx"

                            echo "<h3>Εργασία</h3>";
                            echo "<ul><h4>Στόχοι: </h4>";
                            echo "<ol><li>" . $row["goals"] . "</li></ol>";
                            echo "<h4>Εκφώνηση:</h4>";
                            echo "<ol><li>Κατεβάστε την εκφώνηση της εργασίας απο <a href='$position'>εδώ</a></li></ol>";
                            echo "<h4>Παραδοτέα:</h4>";
                            echo "<ol><li>" . $row["deliverable"] . "</li></ol>";
                            echo "<h4>Ημερομηνία Παράδοσης: " . $row["deliverable_date"] . " </h4></ul>";
                            echo "<hr>";
                        }
                    } else
                        echo "Δεν υπάρχουν εργασίες.";
                    ?>
                </div>
            </div>
        </div>
    </section>

    <button class="scrollToTopBtn">☝️</button>
    <script src="js/index.js"></script>
</body>

</html>