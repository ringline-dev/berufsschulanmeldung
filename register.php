<?php
require_once("db.php");
$con = new DataModel();

class UserModel{   
    const USER_DEFAULT = "admin";
    const PW_DEFAULT = "kbs21admin55";

    function __construct(){
        global $con;
        $this->addUser(self::USER_DEFAULT, self::PW_DEFAULT, "admin");
    }

    function addUser($username, $password, $usertype){
        global $con;
        $query = "SELECT * FROM user where username=?";
        $paramType = "s";
        $paramValue = array($username);
        $result = $con->select($query, $paramType, $paramValue);
        if(empty($result)){
            $query = "INSERT INTO user (username, password, user_type) VALUES (?,?,?);";
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $paramValue = array($username, $pw_hash, $usertype);
            $con->execute($query, "sss", $paramValue);
        } else {
            return false;
        }
    }

    function changePassword($id, $password){
        global $con;
        $query = "UPDATE user SET `password`=? WHERE id=?";
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);
        $paramValue = array($pw_hash,$id);
        $con->execute($query, "si", $paramValue);
    }

    function deleteUser($id){
        global $con;
        $query = "DELETE FROM user WHERE id=?";
        $paramValue = array($id);
        $con->execute($query, "i", $paramValue);
    }

}



?>