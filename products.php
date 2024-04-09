<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
        include "fetchproducts.php";
    ?>
    <main class="mainContent" id="prodMain">
        <table class="prodMenu" id="pMenu">
            <tr>
                <th>products > </th>
                <th><a href="#tshirt">T-shirts</a> </th>
                <th><a href="#hoodie">Hoodies</a> </th>
                <th><a href="#jumper">Jumpers</a> </th>
                <th>
                    <form>
                        <label for="search">Search:</label>
                        <input type="text" id="search" name="search">
                    </form>
                </th>
                <th><button id="searchButton">Search</button></th>
            </tr>
        </table>
        <br/>
        <div class="products" id="hoodie">
            <?php
                products($hoodie);
            ?>
        </div>
        <div class="products" id="jumper">
            <?php
                products($jumper);
            ?>
        </div>
        <div class="products" id="tshirt">
            <?php
                products($tshirt);
            ?>
        </div>
    </main>
    <script src="search.js"></script>
    <?php
        if(isSet($_SESSION["userid"])){
            echo "<script type='text/javascript' src='addToCartSession.js'></script>";
        }
        else{
            echo "<script type='text/javascript' src='addToCart.js'></script>";
        }
        check();
        include "footer.php";
    ?>
</body>
</html>