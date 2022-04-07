<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login Anmelde-Datenbank JPPS</title>
</head>
<body>
    <?php 
        if(isset($_SESSION["errorMessage"])) {
            echo "<div id='login-error'>". $_SESSION["errorMessage"] ."</div>"; 
            unset($_SESSION["errorMessage"]);
        } 
    ?>

    <form action="login_process.php" method="post" class="login">
        Benutzername:<br>
        <input type="text" size="40" maxlength="250" name="user">
         
        Passwort:
        <input type="password" size="40"  maxlength="250" name="pw">
         
        <input type="submit" value="Login">
    </form> 
</body>
</html>