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

    <title>Έγγραφα μαθήματος</title>

    <style>
        <?php include "css/documents.css" ?>
    </style>
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">
</head>

<body>
    <section class="basic-section">
        <div class="header-div">
            <h1>Έγγραφα μαθήματος</h1>
            <img onclick="myFunction()" id="menu-icon-i" src="images/menu.png" alt="menu-icon">
        </div>
        <div class="hero-nav-div">
            <div class="container">
                <div class="nav-div" id="IDnav-div">
                    <ul>
                        <li><b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></li>
                        <li><a href="index.php">Αρχική</a></li>
                        <li><a href="documents.php">Έγγραφα μαθήματος</a></li>
                        <li> <a href="reset-password.php">Αλλαγή Κωδικού</a></li>
                        <li><a href="logout.php">Αποσύνδεση</a></li>
                    </ul>
                </div>
                <div class="hero-div">
                    <?php
                    if ($_SESSION["email"] == "admin@gmail.com") {
                        echo "<div class='admin-div'><a href='addDocument.php'>Προσθήκη Εγγράφου</a></div>";
                    }
                    $sqlPrint = "SELECT title, description, name_position_file from documents";
                    $result = $link->query($sqlPrint);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $position = $row["name_position_file"];
                            echo "<h3>" . $row["title"] . "</h3>";
                            echo "<ul><li><span>Περιγραφή:</span> " . $row["description"] . "</li><li><a href='$position'> Διαφάνειες </a></li></ul>";
                            echo "<hr>";
                        }
                    } else
                        echo "Δεν υπάρχουν έγγραφα.";
                    ?>
                </div>
            </div>
        </div>
    </section>

    <button class="scrollToTopBtn">☝️</button>
    <script src="js/index.js"></script>
</body>

</html>