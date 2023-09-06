
<h1>S'inscrire</h1>

<form action="index.php?ctrl=security&action=register" method="post">
    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" >
    </div>
    <div>
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" >
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password1" id="password1"  >
    </div>
    <div>
        <label for="password">Confirmation du mot de passe :</label>
        <input type="password" name="password2" id="password2"  >
    </div>
    <div>
        <input type="submit" name="submit" id="submit" value="S'enregistrer">
    </div>
</form>