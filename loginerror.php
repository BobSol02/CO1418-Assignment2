<?php
    function check(){
        if(isSet($_POST["error"])){
            echo
            "<script type='text/javascript'>",
                "alert('".$_POST["error"]."');",
            "</script>";
        }
    }
?>