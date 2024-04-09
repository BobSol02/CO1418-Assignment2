<!--404 Page. Redirects to index-->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
    ?>
    <main class="mainContent" id="404">
        <h1>The page you were looking for is not available.</h1>
        <a href="index.php">Go back to main page</a>
    </main>
    <?php
        include "footer.php";
    ?>
</body>
</html>
