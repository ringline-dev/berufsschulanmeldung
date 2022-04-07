<?php
    ini_set('display_errors', '1');
    require_once('db2.php');
    $con = new DataModel();
    $sql = "SELECT * FROM mitglieder where mitgliedsnr > ? and nachname like ?";
    $paramType = "is";
    $paramArray = array(3, 'S%');

    $sql = 'SELECT * FROM user WHERE username = ? or username = ?';
    $paramType = 'ss';

    $paramArray = array("sek", "admin");

    if($res = $con->select($sql, $paramType, $paramArray)){
        echo "<table> 
            <thead id='tableHead'>
                <tr>";
        $properties = array();
        

        //Tabellenköpfe aus Resultset einlesen und in Tabelle anzeigen.
        while($property= mysqli_fetch_field($res)){
            echo "<th>" . $property->name . "</th>";
            $properties[] = $property->name;
        }
        echo "</tr></thead>";
        
        echo "<tbody id='resTable'>";
        while ($ds = mysqli_fetch_assoc($res)){ //holt eine Zeile aus dem Resultset und bewegt den Zeiger eins weiter
            echo "<tr>";
            foreach($properties as $p) { //holt aus der aktuellen Zeile für jede Spalte den Wert
                echo "<td>" . $ds[$p] . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</form>";

    } else {
        echo "<p style='color:#C00C00';>";
        echo "Es ist ein Fehler aufgetreten! Es wurden keine Datensätze gefunden.";
        echo "</p>";
    }

?>