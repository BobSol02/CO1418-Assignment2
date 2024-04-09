<?php
    session_start();
    include_once "databaselogin.php";
    if(isSet($_SESSION["userid"])){
        if(isSet($_POST["id"])){
            $getOrder = $pdo->prepare("SELECT product_ids FROM tbl_orders WHERE user_id = :userid");
            $getOrder->bindParam(":userid", $_SESSION["userid"]);
            $getOrder->execute();
            if($getOrder->rowCount() > 0){
                $order = $getOrder->fetch();
                $products = explode(",",$order["product_ids"]);
                $newOrder = "";
                $flag = false;
                for($i = 0; $i < count($products); $i++){
                    if($products[$i] == $_POST["id"] && !$flag){
                        $flag = true;
                    }
                    else{
                        $newOrder .= $products[$i];
                        if($i<(count($products)-1))
                            $newOrder .= ",";
                    }
                }
                if($newOrder!=""){
                    $stmt = $pdo->prepare("UPDATE tbl_orders SET product_ids = :order WHERE user_id = :userid");
                    $stmt->bindParam(":userid", $_SESSION["userid"]);
                    $stmt->bindParam(":order", $newOrder);
                    $stmt->execute();
                }
                else{
                    $stmt = $pdo->prepare("DELETE FROM tbl_orders WHERE user_id = :userid");
                    $stmt->bindParam(":userid", $_SESSION["userid"]);
                    $stmt->execute();
                }
            }
            header("Location: ".$_POST["url"]);
        }
    }
    else
        header("Location: 404.php");
?>