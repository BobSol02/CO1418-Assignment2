<?php
    include "loginerror.php";
    echo
    '<header class="topNav" id="nav">',
        '<img src="resources/uclan-logo.png" alt="UCLan Logo" class="logo" height="79" width="212"/>',
        '<a href="index.php">Home</a>',
        '<a href="products.php">Products</a>',
        '<a href="cart.php">Cart</a>',
        '<a href="#" id="loginButton">Login</a>',
        '<a href="logout.php" id="logoutButton" style="display: none">Log Out</a>',
        '<a href="javascript:void(0);" class="icon" onclick="respMenu()">',
            '<i class="fa fa-bars"></i>',
        '</a>',
    '</header>';
    echo
    '<dialog id="login">',
        '<button id="closeButton">Close</button>',
        '<br/>',
        '<form id="loginForm" action="login.php" method="POST">',
            '<label for="email">Email:</label>',
            '<input type="email" name="email" id="email" required>',
            '<br/>',
            '<label for="password">Password:</label>',
            '<input type="password" name="password" id="password" required>',
            '<br/>',
            '<input type="hidden" name="current" value="',$_SERVER['REQUEST_URI'],'">',
            '<input type="submit" value="Login">',
        '</form>',
        '<a href="register.php">Register</a>',
    '</dialog>';
    echo
    '<script>',
        'document.getElementById("loginButton").addEventListener("click",function(event){',
            'event.preventDefault();',
            'document.getElementById("login").showModal();',
        '});',
        'document.getElementById("closeButton").addEventListener("click",function(event){',
            'event.preventDefault();',
            'document.getElementById("login").close();',
        '});',
    '</script>';
    if(isSet($_SESSION["userid"])){
        echo
            '<script type="text/javascript">',
                'document.getElementById("loginButton").style.display = "none";',
                'document.getElementById("logoutButton").style.display = "";',
                'document.getElementById("logoutButton").addEventListener("click",function(event){',
                    'event.preventDefault();',
                    'let form = document.createElement("form");',
                    'form.setAttribute("method", "POST");',
                    'form.setAttribute("action", "logout.php");',
                    'let current = document.createElement("input");',
                    'current.setAttribute("type", "hidden");',
                    'current.setAttribute("name", "current");',
                    'current.setAttribute("value","',$_SERVER['REQUEST_URI'],'");',
                    'form.appendChild(current);',
                    'document.body.appendChild(form);',
                    'form.submit();',
                '});',
            '</script>';
    }
?>
