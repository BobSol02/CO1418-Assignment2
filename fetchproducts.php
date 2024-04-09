<?php
    $stmt = $pdo->prepare("SELECT * FROM tbl_products WHERE product_type = :type");
    $tshirt = "UCLan Logo Tshirt";
    $hoodie = "UCLan Hoodie";
    $jumper = "UCLan Logo Jumper";

    function products($type) {
        global $stmt;
        $stmt->bindValue(':type', $type);
        $stmt->execute();
        while($row = $stmt->fetch()) {
            $productID = $row["product_id"];
            $productTitle = $row["product_title"];
            $productImage = $row["product_image"];
            $productDesc= $row["product_desc"];
            $productPrice = $row["product_price"];
            echo
            "<div class='",$productTitle,"' id=",$productID,">",
                "<img src=\"",$productImage,"\" alt=\"",$productTitle,"\" width=\"240px\" height=\"240px\">",
                "<p><b>",$productTitle,"</b></p>",
                "<p>",$productDesc,"</p>",
                "<p>£",$productPrice,"</p>",
                "<a href=\"item.php?item=",str_replace(' ','_',$productTitle),"&id=",$productID,"\">View Details</a><br/>",
                "<button class='addToCart' id=",$productID,">Add to Cart</button>",
            "</div>";
        }
    }
?>