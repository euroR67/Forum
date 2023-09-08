
<h1>S'inscrire</h1>

<form action="" method="post">
    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" required>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password1" id="password1"  minlength="8" required>
    </div>
    <div>
        <label for="password">Confirmation du mot de passe :</label>
        <input type="password" name="password2" id="password2"  minlength="8" required>
    </div>
    <div>
        <input type="submit" name="register" id="submit" value="S'enregistrer">
    </div>
</form>