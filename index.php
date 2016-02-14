<?php
session_start();
require_once "lib/functions.php";
require_once "config.php";
require_once "lib/User.php";
    if(isset($_POST["reg_user"])) {
        $error_login = "";
        $error_password = "";
        $error_email = "";
        $error_reg = "";
        $success_reg = "";
        $login = trim(htmlspecialchars($_POST["login"]));
        $password = trim(htmlspecialchars($_POST["password"]));
        $password_r = trim(htmlspecialchars($_POST["password_r"]));
        $name = trim(htmlspecialchars($_POST["name"]));
        $last_name = trim(htmlspecialchars($_POST["last_name"]));
        $email = trim(htmlspecialchars($_POST["email"]));
        $is_error = false;
        $_SESSION["login_reg"] = $login;
        $_SESSION["password_reg"] = $password;
        $_SESSION["password_reg_r"] = $password_r;
        $_SESSION["name_reg"] = $name;
        $_SESSION["last_name_reg"] = $last_name;
        $_SESSION["email_reg"] = $email;
            if( (iconv_strlen($login)==0) || (iconv_strlen($login)<3) ) {
                $error_login = "Логин должен быть от 3-х символов";
                $is_error = true;
            }
            if( (iconv_strlen($password)==0) || (iconv_strlen($password)<3) ) {
                $error_password = "Пароль должен быть от 3-х символов";
                $is_error = true;
             }
            if( (iconv_strlen($password_r)==0) || (iconv_strlen($password_r)<3) ) {
                $error_password = "Пароль должен быть от 3-х символов";
                $is_error = true;
            }
            if( (iconv_strlen($email)==0) || (iconv_strlen($email)<4) ) {
                $error_email = "E-mail должен быть от 4-х символов";
                $is_error = true;
            }
                $check_pass = checkPasswords($password,$password_r);
                if(!$check_pass) {
                    $error_password = "Пароли не совпадают";
                    $is_error = true;
                }
                    if($is_error==false) {
                        $ip = $_SERVER["REMOTE_ADDR"];
                        $date = date('Y-m-d H:i:s');
                        $group = "Пользователь";
                        $salt = rand(324546,679861);
                        $password = md5(md5($password) . md5($salt));
                        $new_user = new User($login,$password,$salt,$group,$name,$last_name,$email,$ip,$date);
                        if( ($new_user->checkLoginReg()==ERROR_CONNECT_DB) || ($new_user->checkLoginReg($login)==LOGIN_BUSY)) {
                            $error_reg = $new_user->checkLoginReg();
                        }else {
                            if($new_user->addUser()) {
                                $success_reg = "Вы успешно зарегистрировались под логином " . $login;
                            }else {
                                $error_reg = "При регистрации возникла ошибка. Попробуйте снова";
                            }
                        }
                    }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Регистрация пользователя ООП</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
<div id="reg_block">
    <h2>Регистрация</h2>
    <form action="" method="post">
        <table align="center">
            <tr>
                <td><label for="login">Логин<span class="required_field">*</span></label></td>
                <td><input type="text" id="login" name="login" maxlength="20" value="<?=$_SESSION["login_reg"]?>" required /></td>
            </tr>
            <tr>
                <td><label for="password">Пароль<span class="required_field">*</span></label></td>
                <td><input type="password" id="password" name="password" maxlength="20" value="<?=$_SESSION["password_reg"]?>" required /></td>
            </tr>
            <tr>
                <td><label for="password_r">Повторите пароль<span class="required_field">*</span></label></td>
                <td><input type="password" id="password_r" name="password_r" maxlength="20" value="<?=$_SESSION["password_reg_r"]?>" required /></td>
            </tr>
            <tr>
                <td><label for="name">Имя</label></td>
                <td><input type="text" id="name" name="name" maxlength="50" value="<?=$_SESSION["name_reg"]?>"  /></td>
            </tr>
            <tr>
                <td><label for="last_name">Фамилия</label></td>
                <td><input type="text" id="last_name" name="last_name" maxlength="100" value="<?=$_SESSION["last_name_reg"]?>"  /></td>
            </tr>
            <tr>
                <td><label for="email">E-mail<span class="required_field">*</span></label></td>
                <td><input type="email" id="email" name="email" maxlength="20" value="<?=$_SESSION["email_reg"]?>" required /></td>
            </tr>
            <tr>
                <td><input type="reset" value="Очистить форму" /></td>
                <td><input type="submit" name="reg_user" value="Зарегистрироваться" /></td>
            </tr>
        </table>
    </form>
    <div class="error_field"><p><?=$error_login?></p></div>
    <div class="error_field"><p><?=$error_password?></p></div>
    <div class="error_field"><p><?=$error_email?></p></div>
    <div class="error_field"><p><?=$error_reg?></p></div>
    <div class="success_field"><p><?=$success_reg?></p></div>
</div>
</body>
</html>