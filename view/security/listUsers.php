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
        <a href="#">Bannir</a>
    </li>
    <?php } ?>
    
</ul>