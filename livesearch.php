<?php
    require_once "db.php";
    $con = new DataModel();
    if(isset($_GET['q'])){
        $sql = "SELECT * FROM schulen WHERE schule LIKE ? LIMIT 10";
        $q ="%" . $_GET['q'] . "%";
        if($res = $con->select($sql, "s", array($q))){
            while ($ds = mysqli_fetch_assoc($res)){
                echo "<div class='results' data-schulnummer='". $ds['schulnummer'] . "'>" . $ds['schule'] . "</div>";
            }
        } else {
            echo "keine Ergebnisse...";
        }
    } else{
        echo "q nicht da";
    }

?>