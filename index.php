<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UCLan Shop</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
    ?>
    <main class="mainContent" id="main">
        <div id="offers">
            <h2>Special Offers</h2>
            <table >
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM tbl_offers");
                    $stmt->execute();
                    while($row = $stmt->fetch()){
                        echo
                            "<tr>",
                                "<td>",$row["offer_title"],"</td>",
                                "<td>",$row["offer_dec"],"</td>",
                            "</tr>";
                    }
                ?>
            </table>
        </div>
        <h1>
            Where opportunity creates success
        </h1>
        <br/>
        <p>
            Every student at The University of Central Lancashire is automatically a member of the Students' Union.
            We' re here to make life better for students - inspiring you to succeed and achieve your life goals.
        </p>
        <br/>
        <p>
            Everything you need to know about UCLan Students' Union. Your membership starts here.
        </p>
        <br/>
        <h2>
            Together
        </h2>
        <br/>
        <iframe width="560" height="315" src="resources/UCLan%20Together%20-%20Open%20Days.mp4" title="Uclan Together"></iframe>
        <br/>
        <h2>
            Join our global community
        </h2>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/i2CRunZv9CU?si=8sracU_7i2gv-axG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </main>
    <?php
        check();
        include "footer.php";
    ?>
</body>
</html>
