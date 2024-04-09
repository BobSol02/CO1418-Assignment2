<?php
    session_start();
    echo "cool";
    session_destroy();
    header("Location: ".$_POST["current"]);
?>