<?php

$topics = $result["data"]['topics'];
    
?>

<h1>liste topics</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p>
        <a href="index.php?ctrl=forum&action=findPostsByTopics&id=<?=$topic->getId()?>">
            <?=$topic->getTitre()?>
        </a>
    </p>
    <?php
}