<?php
class RegUser {
    public $login;
    public $password;
    public $salt;
    public $group;
    public $name;
    public $last_name;
    public $email;
    public $ip;
    public $date_reg;

    public function  __construct($login,$password,$salt,$group,$name,$last_name,$email,$ip,$date) {
        $this->login = $login;
        $this->password = $password;
        $this->salt = $salt;
        $this->group = $group;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->ip = $ip;
        $this->date_reg = $date;

    }

    public function checkLoginReg() {
        $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
            if($db->connect_errno) {
                return ERROR_CONNECT_DB;
            }else {
                $query = $db->query("SELECT `id` FROM `users` WHERE `login`='$this->login'");
                $result = $query->fetch_assoc();
                if(!empty($result)) {
                    return LOGIN_BUSY;
                }
            }
        $db->close();
    }

    public function addUser() {
            $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
            $query = $db->query("INSERT INTO `users` VALUES('',
                                                            '$this->login',
                                                            '$this->password',
                                                            '$this->salt',
                                                            '$this->group',
                                                            '$this->name',
                                                            '$this->last_name',
                                                            '$this->email',
                                                            '$this->ip',
                                                            '$this->date_reg')");
                if($query) {
                    return true;
                }else {
                    return false;
                }
        $db->close();
        }
}
class AuthUser {
    public $login;
    public $password;
    public $group_user;
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function Authorization()
    {
        $db = new mysqli (HOST_DB, USER_DB, PASS_DB, DB);
        $query = $db->query("SELECT `password`,`salt`,`group_user` FROM `users` WHERE `login`='$this->login'");
        $result = $query->fetch_assoc();
        if (empty($result)) {
            return LOGIN_NOT_FOUND;
        }else {
            if( $result["password"] != md5(md5($this->password).md5($result["salt"])) ) {
                return PASSWORD_DNT_MATCH;
            }else {
                $this->group_user = $result["group_user"];

            }
        }
        $db->close();
    }
}

class InfoUsers {

    public function ShowAllUsers() {
        $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
        $query = $db->query("SELECT * FROM `users`");
        while($res = $query->fetch_assoc()) {
            echo '<p>
                 ID:<b> ' . $res["id"] .
                '</b> Логин:<b> ' .$res["login"] .
                '</b> Статус:<b> ' .
                $res["group_user"] .
                '</b> Имя:<b> ' .
                $res["name"] .
                '</b></p>';
        }
    }

    public function getInfoById($id) {
        $id = (int)$id;
        $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
        $query = $db->query("SELECT * FROM `users` WHERE `id`='$id'");
        $result = $query->fetch_assoc();
            if(empty($result)) {
                echo "Пользователь с таким id не найден";
            }else {
                echo '<p>Информация о пользователе<b> ' . $result["login"] . '</b>:'.'
                      <p>ID ' . $result["id"] . '</p>'.'
                      <p>Пароль(хэш) ' . $result["password"] . '</p>'.'
                      <p>Соль ' .$result["salt"] . '</p>'.'
                      <p>Статус ' .$result["group_user"] . '</p>'.'
                      <p>Имя ' .$result["name"] . '</p>'.'
                      <p>Фамилия ' .$result["last_name"] . '</p>'.'
                      <p>Email ' .$result["email"] . '</p>'.'
                      <p>IP ' .$result["ip"] . '</p>'.'
                      <p>Дата регистрации ' .$result["date"] . '</p>';
                echo '<p id="hide_info"><a href="cabinet.php">Ок</a><p>';
            }
    }
}
?>