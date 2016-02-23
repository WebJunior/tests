<?php
session_start();
require_once "config.php";
require_once "lib/User.php";
    if (isset($_POST["auth_user"])) {
        $is_error = false;
        $login = trim(htmlspecialchars($_POST["auth_login"]));
        $password = trim(htmlspecialchars($_POST["auth_password"]));
            if( iconv_strlen($login)<3 || (iconv_strlen($login)>20)) {
                $_SESSION["error_auth_login"] = "Логин должен быть от 3-х до 20-ти символов";
                $is_error = true;
            }else {
               $_SESSION["error_auth_login"] = "";
            }
            if( iconv_strlen($password)<3 || (iconv_strlen($password)>20)) {
                $_SESSION["error_auth_password"] = "Пароль должен быть от 3-х до 20-ти символов";
                $is_error = true;
            }else {
                $_SESSION["error_auth_password"] = "";
            }
            if($is_error) {
                $_SESSION["error_auth"] = "";
                header('Location: index.php');
            }else {
                $auth_user = new AuthUser($login,$password);
                if ( ($auth_user->Authorization()==LOGIN_NOT_FOUND) || ($auth_user->Authorization()==PASSWORD_DNT_MATCH) ) {
                    $_SESSION["error_auth"] = $auth_user->Authorization();
                    header('Location: index.php');
                }else {
                    $_SESSION["error_auth"] = "";
                    $_SESSION["group_user"] = $auth_user->group_user;
                    $_SESSION["login"] = $login;
                        if($_SESSION["group_user"]=="Администратор") {
                            $_SESSION["admin"] = true;
                        }else {
                            $_SESSION["admin"] = false;
                        }
                    header('Location: cabinet.php');
                }
            }
    }

?>