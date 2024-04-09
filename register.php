<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
    ?>
    <main class="mainContent" id="registerMain">
        <form id="register" onsubmit="" method="post">
            <label>Full Name: <input type="text" id="name" name="name" required></label><br/>
            <label>Email: <input type="email" id="email" name="email" required></label><br/>
            <label>Password: <input type="password" id="password" name="password" minlength="8" required></label><br/>
            <label>Confirm Password: <input type="password" id="confirm" name="confirm" minlength="8" required></label><br/>
            <label>Address: <textarea id="address" name="address" required></textarea></label><br/>
            <input type="submit" value="Register">
        </form>
        <?php
        if(isSet($_SESSION["userid"])){
            header("location: index.php");
        }
        if(isSet($_POST["name"])&&isSet($_POST["email"])&&isSet($_POST["password"])&&isSet($_POST["confirm"])&&isSet($_POST["address"])){
            if($_POST["password"]!=$_POST["confirm"]){
                echo "Passwords do not match!";
            }
            else{
                $exist_stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE user_email = :email");
                $exist_stmt->bindParam(":email", $_POST["email"]);
                $exist_stmt->execute();
                if($exist_stmt->rowCount()>0){
                    echo "<script type='text/javascript'> alert('Email already in use'); </script>";
                    echo
                        '<script type="text/javascript">',
                            'let form=document.createElement("form");',
                            'form.setAttribute("method","POST");',
                            'form.setAttribute("action","return false;");',
                            'let name=document.createElement("input");',
                            'name.setAttribute("type","hidden");',
                            'name.setAttribute("name","name");',
                            'name.setAttribute("value","")',
                            'form.appendChild(name);',
                            'let email=document.createElement("input");',
                            'email.setAttribute("type","hidden");',
                            'email.setAttribute("name","email");',
                            'email.setAttribute("value","");',
                            'form.appendChild(email);',
                            'let password=document.createElement("input");',
                            'password.setAttribute("type","hidden");',
                            'password.setAttribute("name","password");',
                            'password.setAttribute("value","");',
                            'form.appendChild(password);',
                            'let address=document.createElement("input");',
                            'address.setAttribute("type","hidden");',
                            'address.setAttribute("name","address");',
                            'address.setAttribute("value","");',
                            'form.appendChild(address);',
                            'document.body.appendChild(form);',
                            'form.submit();',
                        '</script>';
                    //unset($_POST);
                    header("Refresh:0; Location: register.php");
                }
                else{
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    $register_stmt = $pdo->prepare("INSERT INTO tbl_users (user_full_name,user_email,user_pass,user_address)
                    VALUES (:full_name,:email,:password,:address)");
                    $register_stmt->bindParam(":full_name",$_POST["name"]);
                    $register_stmt->bindParam(":email",$_POST["email"]);
                    $register_stmt->bindParam(":password",$password);
                    $register_stmt->bindParam(":address",$_POST["address"]);
                    $register_stmt->execute();
                    $_POST = array();
                    header("Refresh:0; Location: index.php");
                }
            }
        }
        ?>
    </main>
    <?php
        check();
        include "footer.php";
    ?>
</body>
</html>

