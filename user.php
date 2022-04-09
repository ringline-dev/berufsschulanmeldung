<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    $logout_time = 60*30;
    //$logout_time = 5;
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

    if($_SESSION['userType'] != "admin"){
        header("Location: admin.php");
        exit();
    }

    require_once("db.php");
    require_once("register.php");
    $con = new DataModel();
    $um = new UserModel();
    $date = date('Y-m-d');  
    $ids = array();

    if(isset($_POST['id'])){
        $um->deleteUser($_POST['id']);
    }

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBS online Nutzerverwaltung</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <script src="https://kit.fontawesome.com/20dc5d6c1a.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
        require_once("editForm.php");  
        require_once("addForm.php");  
    ?>
    <div id="overlay"></div>
    <div class="wrapper">
        <nav class="admin">
            <div class="logo"><img src="img/logo_cut.png"/></div>
            <form action="admin.php">
                <button type="submit" id="back">&#9666; Zurück</button>
            </form>
        </nav>
        <div id='table'>
            
        <?php
            if(isset($_POST['editUser'])){
                if(! empty($_POST['idChange'])){
                    if($_POST['password1'] == $_POST['password2']){
                        $um->changePassword($_POST['idChange'], $_POST['password1']);
                        echo "<div class='message'>Passwort geändert.</div>";
                    } else echo "<div class='message'>Passwörter stimmen nicht überein!</div>";
                } else echo "<div class='message'>Passwortänderung fehlgeschlagen!</div>";
            }

            if(isset($_POST['addUser'])){
                if(! empty($_POST['idAdd'])){
                    if(! empty($_POST['username']) && ! empty($_POST['password1']) && ! empty($_POST['password2'])){
                        if($_POST['password1'] !=  $_POST['password2']){
                            echo "<div class='message'>Passwörter stimmen nicht überein!</div>";
                        } else{
                            $um->addUser($_POST['username'], $_POST['password1'], $_POST['userType']);
                        };
                    } else echo "<div class='message'>Bitte alle Felder ausfüllen!</div>";
                } else echo "<div class='message'>Fehlgeschlagen!</div>";
            }
        ?>
            
        <?php
            $sql = "SELECT id, username, user_type FROM user;";
            if($res = $con->select($sql)){
                echo "<p class='info'>Logged in as <strong>" . $_SESSION['user'] . "</strong></p><h2>Benutzerverwaltung</h2><table id='userTable'> 
                    <thead id='tableHeadUser'>
                        <tr>";
                $properties = array();
                
                //Tabellenköpfe aus Resultset einlesen und in Tabelle anzeigen.
                while($property= mysqli_fetch_field($res)){
                    echo "<th>" . $property->name . "</th>";
                    $properties[] = $property->name;
                }
                echo "<th></th>
                    <th></th>
                    </tr></thead>";
                
                echo "<tbody id='resTable'>";
                while ($ds = mysqli_fetch_assoc($res)){ //holt eine Zeile aus dem Resultset und bewegt den Zeiger eins weiter
                    $id = $ds['id'];
                    $name = $ds['username'];

                    foreach($properties as $p) { //holt aus der aktuellen Zeile für jede Spalte den Wert
                        echo "<td>" . $ds[$p] . "</td>";
                    }
                    echo "<td><button class='editButton' data-id=".$id." data-name =".$name.">ändern <span class='fas fa-edit'></span></button</td>
                    <td><form method='post' onsubmit='return confirm(\"Soll der Nutzer $name wirklich gelöscht werden?\");' action='user.php' data-id=".$id." data-name =".$name."><input type='hidden' name='id'  value=$id></input><button class='deleteButton'>löschen <span class='far fa-trash-alt'></span></button></form></td>
                        </tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<button class='addButton' name='add'> + Neuer Nutzer </button>";

            } else {
                echo "<p style='color:#C00C00';>";
                echo "Es ist ein Fehler aufgetreten! Es wurden keine Datensätze gefunden.";
                echo "</p>";
            }

        ?>
        </div>
    </div>
    <script>
        let editButtons = document.querySelectorAll(".editButton");
        let editPopup = document.querySelector("#editPopup")
        let deleteButtons = document.querySelectorAll(".deleteButton");
        let addButtons = document.querySelectorAll(".addButton");
        let addPopup = document.querySelector("#addPopup")
        let idInput = document.querySelectorAll('.idInput');
        let userName = document.querySelector("#userName");
        let overlay = document.querySelector("#overlay");
        let closeBtn = document.querySelectorAll(".close-btn");
        let passwordInput = document.querySelectorAll("#editForm input[type='password']");
        let editSubmit = document.querySelector("#editSubmit");
        
        function getID(e){
            idInput.forEach(input => input.value = e.target.dataset.id);
        }

        function editUser(e){
            userName.innerHTML = "Passwort ändern für " + e.target.dataset.name;
        }


        function activateButton(e){
            let full = true;
            passwordInput.forEach(function(input){
                if(input.value === "") full = false;
            });
            if(full){
                editSubmit.disabled = false;
            } else {
                editSubmit.disabled = true;
            }
        }

        function toggleActive(e){
            if(e.target.className == "editButton"){
                editPopup.classList.add('active');
            } else if(e.target.className == "addButton"){
                addPopup.classList.add('active');
            } else {
                addPopup.classList.remove('active'); 
                editPopup.classList.remove('active'); 
            }
            overlay.classList.toggle('active');
        }

        editButtons.forEach(button => button.addEventListener('click', editUser));
        editButtons.forEach(button => button.addEventListener('click', getID));
        editButtons.forEach(button => button.addEventListener('click', toggleActive));
        addButtons.forEach(button => button.addEventListener('click', getID));
        addButtons.forEach(button => button.addEventListener('click', toggleActive));
        overlay.addEventListener('click', toggleActive);
        passwordInput.forEach(input => input.addEventListener('keyup', activateButton));
        closeBtn.forEach(button=>button.addEventListener('click', toggleActive));

    </script>
</body>
</html>