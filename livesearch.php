<?php
    require_once "db.php";
    $con = new DataModel();
    if(isset($_GET['q'])){
        $sql = "SELECT * FROM schulen WHERE schule LIKE ? OR ort like ? LIMIT 50";
        $q ="%" . $_GET['q'] . "%";
        if($res = $con->select($sql, "ss", array($q, $q))){
            while ($ds = mysqli_fetch_assoc($res)){
                echo "<div class='results' data-schulnummer='". $ds['schulnummer'] . "'>" . $ds['schule'] . " - " . $ds['ort'] . "</div>";
            }
        } else {
            echo "<div class='results' data-schulnummer=''>Keine Ergebnisse...</div>";
        }
    } else{
        echo "q nicht da";
    }

?>