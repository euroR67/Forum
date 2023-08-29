<?php

$topics = $result["data"]['topics'];
    
?>

<h1>Topics de la catégorie</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p>
        <a href=""><?=$topic->getTitre()?></a>
    </p>
    <?php
}