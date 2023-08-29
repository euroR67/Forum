<?php

$categories = $result["data"]['categories'];
    
?>

<h1>liste categories</h1>

<?php
foreach($categories as $categorie ){

    ?>
    <p>
        <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?=$categorie->getId()?>">
        <?=$categorie->getNomCategorie()?></a>
    </p>
    <?php
}