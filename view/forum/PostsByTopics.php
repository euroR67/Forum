<?php

$posts = $result["data"]['posts'];
    
?>

<h1>Posts du sujet</h1>

<?php
foreach($posts as $post ){

    ?>
    <p><?=$post->getTexte()?></p>
    <?php
}