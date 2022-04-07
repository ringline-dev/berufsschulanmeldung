<div class="popup" id="editPopup">
    <div class="close-btn">&times;</div>
    <div id="userName">FEHLER!</div>
    <form id="editForm" action="user.php" method="post" autocomplete="off"> 
        <input type="hidden" name="idChange" class="idInput"> 
        <input type="password" name="password1" placeholder="Neues Passwort">
        <input type="password" name="password2" placeholder="Passwort wiederholen">
        <input type="submit" value="Passwort ändern" id="editSubmit" name="editUser" disabled>
    </form>
</div>

