<?php

$posts = $result["data"]['posts'];
$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];
    //  var_dump($categories);die;
?>

<h1>
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> > 
    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?=$categories->getId()?>"><?= $categories->getNomCategorie() ?></a>
    <?= $topics->getTitre() ?>
</h1>

<?php 
foreach($posts as $post ){

    ?>
    <p><?=$post->getTexte()?></p>
    <?php
    
}
