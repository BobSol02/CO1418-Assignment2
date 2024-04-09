<?php
    session_start();
    include "databaselogin.php";
    if(isSet($_SESSION["userid"])&&isSet($_POST["checkout"])){
        $stmt = $pdo->prepare("DELETE FROM tbl_orders WHERE user_id = :userid");
        $stmt->bindParam(":userid", $_SESSION["userid"]);
        $stmt->execute();
        header("Location: cart.php");
    }
    else
        header("Location: 404.php");
?>