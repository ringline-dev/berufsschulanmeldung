<?php
    session_start();
    //ini_set('display_errors', '1');
    $logout_time = 60*30;

    $now = time();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    if(isset($_SESSION['logout_time']) && $now > $_SESSION['logout_time']){
        unset($_SESSION['login']);
        unset($_SESSION['logout_time']);
        $_SESSION["errorMessage"] = "Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["logout_time"] = $now + $logout_time;
    }

    if(ISSET($_POST['ids'])){
        $_SESSION['ids'] = $_POST['ids'];
        echo "
            <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>Anmeldung KBS Administration</title>
                    <link rel='stylesheet' href='style.css'>
                </head>
                <body>
                <div class='success'>
                    <p><a href='download.php' target='_blank' onclick='downloadRequest()'>Datei herunterladen und zurück zur Hauptseite</a>
                    </p>
                </div>
                </body>
                </html>";
    } else {
        header("Location: admin.php");
        exit();
    }
?>
<script>
    function downloadRequest(e){
        setTimeout(function(){ window.location = "admin.php"; }, 30);
    }
</script>