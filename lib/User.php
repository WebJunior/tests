<?php
class User {
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
?>