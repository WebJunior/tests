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
        echo "<p>Логин <b>" . $_SESSION["login"] . "</b></p>";
        echo "<p>Статус <b>" . $_SESSION["group_user"] . "</b></p>";
        echo '<p id="exit_cab"><a href="exit.php">Выход</a></p>';
        ?>
    </div>
    <div id="block_all_users">

    </div>
</body>
</html>
