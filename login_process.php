<?php
    session_start();
    ini_set('display_errors', '1');
    //$user_default = "sek";
    //$pw_default = "JPPS2021!";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once("db.php");
        $con = new DataModel();
        $query = 'SELECT * FROM user WHERE username = ?';
        $paramType = 's';
        $paramValue = array($_POST['user']);
        $result = $con->select($query, $paramType, $paramValue);
        if(! empty($result)){
            while($row = $result->fetch_array()){
                $pw = $_POST['pw'];
                $pw_hash = $row["password"]; 
                if (password_verify($pw, $pw_hash)) {
                    $_SESSION['user'] = $row["username"];
                    $_SESSION['userType'] = $row["user_type"];
                    header("Location: admin.php");
                }else{
                    $_SESSION['errorMessage'] = "Login nicht erfolgreich.";    
                    header("Location: login.php");
                    exit();
                }
            }

        }else{
            $_SESSION['errorMessage'] = "Login nicht erfolgreich.";    
            header("Location: login.php");
            exit();
        }
    }
?>