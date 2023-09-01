<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>
<h1> 
    <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> > 
    <a href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?= $topic->getCategorie()->getId() ?>"><?=$topic->getCategorie() ?></a> >
    <?= $topic->getTitre() ?>
</h1>

<div class="posts-container">
    <?php foreach ($posts as $post) { ?>
        <div class="post-block">
            <div class="post-info">
                <figure>
                    <img src="https://picsum.photos/50/50" alt="">
                </figure>
                <div class="user-date">
                    <a href="#">
                        <?= $post->getUser() ?>
                    </a>
                    <p>Le <?= $post->getDatePost() ?></p>
                </div>
            </div>
            <p><?= $post->getTexte() ?></p>
            <?php
                // Vérifier si le post n'est pas le premier post du topic
                if (!$post->isFirstPost()) {
                    // Afficher le bouton "SUPPRIMER" avec un lien vers l'action de suppression
                    ?>
                    <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">SUPPRIMER</a>
                    <?php
                }
                ?>
        </div>
        <?php } ?>
        <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post" enctype="multipart/form-date">
            <label>Répondre</label>
            <textarea placeholder="Apporter une réponse au sujet.." name="text"></textarea>
            <input class="submit" type="submit" name="submit" value="POSTER">
        </form>
</div>