<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    $logout_time = 60*30;

    $now = time();

    if(isset($_SESSION['logout_time']) && $now > $_SESSION['logout_time']){
        unset($_SESSION['login']);
        unset($_SESSION['logout_time']);
        $_SESSION["errorMessage"] = "Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.";
        session_write_close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["logout_time"] = $now + $logout_time;
    }
    
    require_once("db.php");

    $sql = "DELETE FROM asv ";

    $con = new DataModel();

    $c=0;
    if(isset($_POST['ids'])){
        $c = count($_POST['ids']);
        $sql .= "WHERE id_asv = ";
        for($i=0; $i < $c-1; $i++){
            $sql .= $_POST['ids'][$i];
            $sql .= " OR id_asv = ";
        }
        $sql .= $_POST['ids'][$c-1];
    } else {
        exit();
    }
    $sql .= ";";

    $res = $con->execute($sql);

    if(empty($res)){
        echo "<p style='color:#C00C00';>";
        echo "Es ist ein Fehler aufgetreten! Es wurden keine Datensätze gefunden.";
        echo "</p>";
    }

?>