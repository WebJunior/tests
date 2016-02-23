<?php
session_start();
if (!isset($_SESSION["login"])) {
    echo '<h2>Для входа в личный кабинет нужно <a href="index.php">авторизоваться</a>';
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    <div id="block_info_user">
        <h3>Личный кабинет</h3>
        <?php
        require_once "config.php";
        require_once "lib/User.php";
        echo "<p>Логин <b>" . $_SESSION["login"] . "</b></p>";
        echo "<p>Статус <b>" . $_SESSION["group_user"] . "</b></p>";
        if($_SESSION["admin"]) {
            echo '<form action="" method="get">
                  <p>Информация по id пользователя
                  <input type="text" id="show_info" name="show_info" maxlength="10" size="2" title="Введите id пользователя" />
                  <input type="submit" name="show_info_user" value="show" /></p>
                  </form>';
        }
        echo '<p id="exit_cab"><a href="exit.php">Выход</a></p>';
        if (isset($_GET["show_info_user"])) {
            $show_info = new InfoUsers();
            $show_info->getInfoById($_GET["show_info"]);
        }
        ?>
    </div>
    <div id="block_all_users">
        <h2>Список пользователей</h2>
        <?php
            $info = new InfoUsers();
            $info->ShowAllUsers();
        ?>
    </div>
</body>
</html>
