<!--Cart page-->
<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>
    <script src="cart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
    ?>
    <main class="mainContent" id="cartMain">
        <h1>Shopping Cart</h1>
        <p>The items added to your shopping cart are:</p>
        <table id="cartTable">
            <?php
                // Check if logged in.
                if(isSet($_SESSION["userid"])){
                    $order_stmt = $pdo->prepare("SELECT product_ids FROM tbl_orders WHERE user_id = :user_id");
                    $order_stmt->bindParam(":user_id", $_SESSION["userid"]);
                    $order_stmt->execute();
                    if($order_stmt->rowCount() > 0){
                        $order = $order_stmt->fetch();
                        $products = explode(',', $order["product_ids"]);
                        $product_stmt = $pdo->prepare("SELECT * FROM tbl_products WHERE product_id = :_product_id");
                        for($i=0; $i<count($products); $i++){
                            $product_stmt->bindParam(":_product_id", $products[$i]);
                            $product_stmt->execute();
                            $product = $product_stmt->fetch();
                            echo
                            "<tr>",
                                "<td><img src=\"",$product["product_image"],"\" alt=\"",$product["product_title"],"\" width=\"240px\" height=\"240px\"></td>",
                                "<td><p><b>",$product["product_title"],"</b></p><td/>",
                                "<td><p>",$product["product_desc"],"</p></td>",
                                "<td><p class='price' id='",$product["product_price"],"'>£",$product["product_price"],"</p></td>",
                                "<td><button class='removeFromCart' id=",$products[$i],">Remove From Cart</button></td>",
                            "</tr>";
                        }
                    }
                }
                else{
                    // Only refresh once.
                    if(!isSet($_POST["prevent"]))
                        echo
                            "<script type='text/javascript'>",
                            "cart();",
                            "</script>";
                    if(isSet($_POST["order"])){
                        $order = $_POST["order"];
                        $products = explode(',', $order);
                        $product_stmt = $pdo->prepare("SELECT * FROM tbl_products WHERE product_id = :product_id");
                        for($i=0; $i<count($products); $i++){
                            $product_stmt->bindParam(":product_id", $products[$i]);
                            $product_stmt->execute();
                            $product = $product_stmt->fetch();
                            echo
                            "<tr>",
                                "<td><img src=\"",$product["product_image"],"\" alt=\"",$product["product_title"],"\" width=\"240px\" height=\"240px\"></td>",
                                "<td><p><b>",$product["product_title"],"</b></p></td>",
                                "<td><p>",$product["product_desc"],"</p></td>",
                                "<td><p class='price' id='",$product["product_price"],"'>£",$product["product_price"],"</p></td>",
                                "<td><button class='removeFromCart' id=",$products[$i],">Remove From Cart</button></td>",
                            "</tr>";
                        }
                    }
                }
            ?>
        </table>
        <?php
            echo "<div id='total'>Total: £</div>";
            echo
                "<script type='text/javascript'>",
                "total();",
                "</script>";
            // Check if logged in before providing checkout button.
            if(isSet($_SESSION["userid"])){
                echo "<button id='checkout'>Checkout</button>";
                echo
                    "<script type='text/javascript'>",
                    "checkout();",
                    "</script>";
            }
            // If not logged in provide error message.
            else{
                echo "</br>You must be logged in to check out.";
            }
        ?>
    </main>
    <?php
        // Check whether user is logged in.
        if(isSet($_SESSION["userid"])){
            echo "<script type='text/javascript'> removeFromCartSession(); </script>";
        }
        else{
            echo "<script type='text/javascript'> removeFromCart(); </script>";
        }
        check();
        include "footer.php";
    ?>
    </body>
</html>