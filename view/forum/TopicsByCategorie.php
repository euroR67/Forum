<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];
// var_dump($categories); die;
?>

<h1><?=$categories->getNomCategorie()?></h1>

<?php

if (empty($topics)) {
    echo "<p>Aucun sujet n'a été trouvé dans cette catégorie.</p>";
} else {
    foreach($topics as $topic ){

        ?>
        <p>
            <a href="index.php?ctrl=forum&action=findPostsByTopics&id=<?=$topic->getId()?>">
                <?=$topic->getTitre()?>
            </a>
        </p>
        <?php
    }
}