<?php
    session_start();
    ini_set('display_errors', '1');

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    } 
    
    $logout_time = 60*30;
    $now = time();

    if(isset($_SESSION['logout_time']) && $now > $_SESSION['logout_time']){
        unset($_SESSION['login']);
        unset($_SESSION['logout_time']);
        unset($_SESSION['user']);
        $_SESSION["errorMessage"] = "Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["logout_time"] = $now + $logout_time;
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBS online Administration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body >
    <div class="wrapper" >
        <nav class="admin" >
            <!-- <div class="logo"><img src="img/logo-ksn_cut.png"/></div> -->
            <div class="logo"><img src="img/jpp-logo_cut.jpg" /></div>
            <button type="submit" id="downloadButton" name="download" form='table'>Ausgewählte herunterladen</button>
            <button type="submit" id="deleteButton" name="delete" form="table">Ausgewählte löschen</button>
            <form id="userButton" action="user.php" <?php if($_SESSION['userType'] != "admin") echo "style='display: none;'" ?>>
                <button type="submit" id="logout">Nutzerverwaltung</button>
            </form>
            <form method="post" action="logout.php">
                <button type="submit" id="logout">Logout</button>
            </form>
        </nav>
        <?php
            require_once("db.php");
            require_once("admin_select.inc");
            
            $date = date('Y-m-d');  
            $con = new DataModel();

            $ids = array();
            
            if($res = $con->select($sql)){
                echo "<form method='post' action='download_process.php' id='table'><p class='info'>Logged in as <strong>" . $_SESSION['user'] . "</strong</p><h2>Anmeldungen</h2><table> 
                    <thead id='tableHead'>
                        <tr>
                            <th id='auswahl'>Auswahl</th>";
                $properties = array();
                

                //Tabellenköpfe aus Resultset einlesen und in Tabelle anzeigen.
                while($property= mysqli_fetch_field($res)){
                    echo "<th>" . $property->name . "<div class='arrow-up'></div>
                    <div class='arrow-down'></div></th>";
                    $properties[] = $property->name;
                }
                echo "</tr></thead>";
                
                echo "<tbody id='resTable'>";
                while ($ds = mysqli_fetch_assoc($res)){ //holt eine Zeile aus dem Resultset und bewegt den Zeiger eins weiter
                    $id = $ds['id'];
                    if($ds['download'] == 1){
                        echo "<tr class='download'>";
                    } else echo "<tr>";
                    echo "<td><input type='checkbox' id='cb$id' name='ids[]' value='$id'></td>";
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
    </div>
    <script>
        const tableHead = document.querySelector('#tableHead');
        const resTable = document.querySelector('#resTable');
        const deleteButton = document.querySelector('#deleteButton');
        let sort = "asc";
        let spalte="id_asv";

        function sortView(e){
            if (!e || !e.target.matches('th') ){
                spalte = "download";
                return;
            }
            let th = e.target;
            if(th.id == "auswahl") return;
            let arrows = tableHead.querySelectorAll('.active');
            arrows.forEach(a => a.classList.remove('active'));
            
            if(spalte == th.innerText){
                sort = (sort=="asc") ? "desc" : "asc";
            } else {
                sort = "asc";
                spalte = th.innerText;
            }
            if(sort=="asc"){
                th.querySelector('.arrow-down').classList.add('active');
           } else{
                th.querySelector('.arrow-up').classList.add('active');
           }
        }

        function getRequest(e){
            sortView(e);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    resTable.innerHTML = this.responseText;           
                }
            };
            xhttp.open('GET', 'getTable.php?spalte=' + spalte + '&sort=' + sort, true); 
            xhttp.send();
        }

        function delRequest(e){
            e.preventDefault();
            let checkboxes = document.querySelectorAll("input[name='ids[]']:checked");
            if(!checkboxes.length>0) return;
            if(!confirm('Wollen Sie die ausgewählten Datensätze löschen? \n\nDiese Aktion kann nicht rückgängig gemacht werden!!')) return;
            let fd = new FormData();
            for(let i=0; i<checkboxes.length; i++){
                fd.append(checkboxes[i].name, checkboxes[i].value);
            }
            //console.log(fd.getAll('ids[]'));
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    getRequest();
                }
            };
            xhttp.open('POST', 'delTable.php', true); 
            xhttp.send(fd);
        }

        deleteButton.addEventListener('click', delRequest);
        tableHead.addEventListener('click', getRequest);

    </script>
</body>
</html>