<?php
class User {
    public $id;
    public $login;
    public $password;
    public $group;
    public $name;
    public $last_name;
    public $email;
    public $ip;
    public $date_reg;



    public function getAllInfoUser($id) {

    }

    public function checkLoginReg($login) {
        $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
            if($db->connect_errno) {
                return ERROR_CONNECT_DB;
            }else {
                $query = $db->query("SELECT `id` FROM `users` WHERE `login`='$login'");
                $result = $query->fetch_assoc();
                if(!empty($result)) {
                    return LOGIN_BUSY;
                }
            }
        $db->close();
    }

    public function addUser($login,$password,$salt,$group,$name,$last_name,$email,$ip,$date) {
            $db = new mysqli(HOST_DB,USER_DB,PASS_DB,DB);
            $query = $db->query("INSERT INTO `users` VALUES('',
                                                            '$login',
                                                            '$password',
                                                            '$salt',
                                                            '$group',
                                                            '$name',
                                                            '$last_name',
                                                            '$email',
                                                            '$ip',
                                                            '$date')");
                if($query) {
                    return true;
                }else {
                    return false;
                }
        $db->close();
        }
}
?>