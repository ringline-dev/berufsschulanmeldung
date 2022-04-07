<div class="popup" id="addPopup">
    <div class="close-btn">&times;</div>
    <h2>Neuen Nutzer anlegen</h2>
    <form id="addForm" action="user.php" method="post" autocomplete="off"> 
        <input type="hidden" name="idAdd" class="idInput"> 
        <label for="usertype">Benutzertyp</label>
        <select id="userType" name="userType">
            <option value="user">Nutzer</option>
            <option value="admin">Administrator</option>
        </select>
        <label for="username">Benutzername</label>
        <input type="text" name="username">
        <label for="password1">Passwort</label>
        <input type="password" name="password1">
        <label for="password2">Passwort wiederholen</label>
        <input type="password" name="password2">
        <input type="submit" value="Nutzer anlegen" id="addSubmit" name="addUser">
    </form>
</div>

