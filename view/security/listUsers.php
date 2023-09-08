<?php 
$users = $result["data"]["users"]; 
?>

<ul>
    <h1>Tout les membres du forum</h1>
    <?php
    foreach($users as $user) { ?>
    <li style="padding:10px; display: flex; gap: 20px; border-bottom: 1px solid grey;">
        <a href="index.php?ctrl=security&action=profile&id=<?=$user->getId()?>">
            <?=$user->getPseudo()?>
        </a>
        <p><?=$user->getDateInscription()?></p>
        <p><?=$user->getRole()?></p>
        <p><?=$user->getEmail()?></p>
        <!-- Bouton pour bannir un utilisateur -->
        <?php if($user->getBannedUntil() == NULL) { ?>
            <button>Bannir</button>
            <!-- Si bouton ban cliqué on affiche un input type date pour choisir la durée du ban -->
            <form style="display:none" action="index.php?ctrl=security&action=banUser&id=<?=$user->getId()?>" method="post">
                <input type="date" name="bannedUntil">
                <input type="submit" name="submit" value="Bannir">
            </form>
        <?php } else { ?>
            <p>Banni jusqu'au <?=$user->getBannedUntil()?></p>
            <a href="index.php?ctrl=security&action=unbanUser&id=<?=$user->getId()?>">Débannir</a>
        <?php } ?>
    </li>
    <?php } ?>
    
</ul>

<script>

// On récupère tout les boutons bannir
let banButtons = document.querySelectorAll("button");

// On boucle sur tout les boutons bannir
banButtons.forEach(banButton => {

    // On ajoute un event listener sur chaque bouton bannir
    banButton.addEventListener("click", function() {

        // On récupère le form juste après le bouton bannir
        let form = banButton.nextElementSibling;

        // On affiche le form
        form.style.display = "block";

        // On cache le bouton bannir
        banButton.style.display = "none";

    })

})


</script>