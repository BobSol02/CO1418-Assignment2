<?php
    include_once "databaselogin.php";
    if(isSet($_POST['email'])&&isSet($_POST['password'])) {
        $password = $_POST["password"];
        $email = $_POST['email'];
        $stmt = $pdo->prepare("SELECT user_pass FROM tbl_users WHERE user_email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        error_log("cool");
        if ($stmt->rowCount() > 0) {
            $serverPassword = $stmt->fetch();
            if (password_verify($password, $serverPassword['user_pass'])) {
                $userData = $pdo->prepare("SELECT * FROM tbl_users WHERE user_email = :email AND user_pass = :password");
                $userData->bindParam(":email", $email);
                $userData->bindParam(":password", $serverPassword['user_pass']);
                $userData->execute();
                $session = $userData->fetch();
                session_start();
                $_SESSION['userid'] = $session["user_id"];
                $_SESSION['name'] = $session["user_full_name"];
                header("Location: ".$_POST["current"]);
            } else {
                echo "Wrong password";
                echo
                    "<script type='text/javascript'>",
                        "let current = '",$_POST["current"],"'.split('/').pop();",
                        "let form = document.createElement('form');",
                        "form.setAttribute('method', 'post');",
                        "form.setAttribute('action',current);",
                        "let error = document.createElement('input');",
                        "error.setAttribute('type', 'hidden');",
                        "error.setAttribute('name', 'error');",
                        "error.setAttribute('value', 'Wrong Password');",
                        "form.appendChild(error);",
                        "document.body.appendChild(form);",
                        "form.submit();",
                    "</script>";
            }
        } else{
            echo "Account does not exist";
            echo
                "<script type='text/javascript'>",
                    "let current = '",$_POST["current"],"'.split('/').pop();",
                    "let form = document.createElement('form');",
                    "form.setAttribute('method', 'post');",
                    "form.setAttribute('action',current);",
                    "let error = document.createElement('input');",
                    "error.setAttribute('type', 'hidden');",
                    "error.setAttribute('name', 'error');",
                    "error.setAttribute('value', 'Account does not exist');",
                    "form.appendChild(error);",
                    "document.body.appendChild(form);",
                    "form.submit();",
                "</script>";
        }
    }
?>