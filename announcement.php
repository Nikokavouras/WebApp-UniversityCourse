<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Announcement Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ανακοινώσεις</title>

    <style>
        <?php include "css/announcement.css"; ?>
    </style>
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">
</head>

<body>
    <section class="basic-section">
        <div class="header-div">
            <h1>Ανακοινώσεις</h1>
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
                    $loggedAdmin = false;
                    if ($_SESSION["email"] == "admin@gmail.com") {
                        echo "<div class='admin-div'><a href='addAnnouncement.php'>Προσθήκη Ανακοίνωσης</a></div>";
                        $loggedAdmin = true;
                    }
                    if (!$loggedAdmin) {
                        $sqlPrint = "SELECT id, project, maintext, created_at from announcements";
                        $result = $link->query($sqlPrint);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>
                                <h3><?php echo $row["project"] ?></h3>
                            <?php
                                echo "<ul><li><span>Κείμενο</span> " . $row["maintext"] . "</li>";
                                echo "<li><span>Ημερομηνία</span> " . $row["created_at"] . "</li>";
                                echo "</ul><hr>";
                            }
                        } else
                            echo "Δεν υπάρχουν ανακοινώσεις.";
                    } else {
                        $sqlPrint = "SELECT id, project, maintext, created_at from announcements";
                        $result = $link->query($sqlPrint);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <div class="title-div">
                                    <h3><?php echo $row["project"] ?></h3><span><a href="editAnnouncement.php?id=<?php echo $row["id"]; ?>">Επεξεργασία</a><a href="deleteAnnouncement.php?id=<?php echo $row["id"]; ?>">Διαγραφή</a><span>
                                </div>
                    <?php
                                echo "<ul><li><span>Κείμενο:</span> " . $row["maintext"] . "</li>";
                                echo "<li><span>Ημερομηνία δημιουργίας:</span> " . $row["created_at"] . "</li>";
                                echo "</ul><hr>";
                            }
                        } else
                            echo "Δεν υπάρχουν ανακοινώσεις.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <button class=" scrollToTopBtn">☝️</button>
    <script src="js/index.js"></script>
</body>

</html>