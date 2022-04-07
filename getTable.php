<?php
    session_start();
    //ini_set('display_errors', '1'); 
    $logout_time = 60*30;
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    $now = time();
    if(isset($_SESSION['logout_time']) && $now > $_SESSION['logout_time']){
        unset($_SESSION['login']);
        unset($_SESSION['logout_time']);
        $_SESSION["errorMessage"] = "Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.";
        session_write_close();
        header("Location: login.php");
        exit();
    } else{
        $_SESSION["logout_time"] = $now + $logout_time;
    }

    require_once("db.php");
    require_once("admin_select.inc");

    $con = new DataModel();

    $res = $con->select($sql);

    if(! empty($res)){
        $properties = array();
        while($property= mysqli_fetch_field($res)){
            $properties[] = $property->name;
        }

        while ($ds = mysqli_fetch_assoc($res)){
            $id = $ds['id'];
            if($ds['download'] == 1){
                echo "<tr class='download'>";
            } else echo "<tr>";
            echo "<td><input type='checkbox' id='cb$id' name='ids[]' value='$id'></td>";
            foreach($properties as $p) {
                echo "<td>" . $ds[$p] . "</td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<p style='color:#C00C00';>";
        echo "Es ist ein Fehler aufgetreten! Es wurden keine Datensätze gefunden.";
        echo "</p>";
    }

?>