<!--Add to cart for logged in users. Php part.-->
<?php
    session_start();
    include_once "databaselogin.php";
    if(isSet($_SESSION["userid"])){
        if(isSet($_POST["order"])){
            // SELECT statement
            $getOrder = $pdo->prepare("SELECT product_ids FROM tbl_orders WHERE user_id = :userid");
            $getOrder->bindParam(":userid", $_SESSION["userid"]);
            $getOrder->execute();
            // Update the row if an order already exists.
            if($getOrder->rowCount() > 0){
                $order = $getOrder->fetch();
                $newOrder = $order["product_ids"];
                echo $newOrder."</br>";
                $newOrder .= ",".$_POST["order"];
                echo $newOrder;
                $stmt = $pdo->prepare("UPDATE tbl_orders SET product_ids = :order WHERE user_id = :userid");
                $stmt->bindParam(":userid", $_SESSION["userid"]);
                $stmt->bindParam(":order", $newOrder);
                $stmt->execute();
            }
            // Otherwise create new order.
            else{
                $order = $_POST["order"];
                $stmt = $pdo->prepare("INSERT INTO tbl_orders (user_id, product_ids) VALUES (:userid, :order)");
                $stmt->bindParam(":userid", $_SESSION["userid"]);
                $stmt->bindParam(":order", $order);
                $stmt->execute();
            }
            header("Location: ".$_POST["url"]);
        }
    }
    // Redirect to 404.php if somehow you managed to get in here without being logged in
    else
        header("Location: 404.php");
?>