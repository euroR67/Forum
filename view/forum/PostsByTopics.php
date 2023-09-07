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
    <div class="titre-sujet">
        <div>
            <h2 id="topic-title">Sujet : <?= $topic->getTitre() ?></h2>

            <!-- On fait apparaitre l'input qui permet de modifier le titre du sujet avec form -->
            <form id="edit-form" action="index.php?ctrl=forum&action=editTopicTitle&id=<?= $topic->getId() ?>" method="post">
                <input type="text" name="titre" value="<?= $topic->getTitre() ?>">
                <input type="submit" value="Modifier">
                <!-- Bouton pour annuler la modification en faisant display none sur le form et display block sur topic-title -->
                <a class="cancel-update-title" href="/">Annuler</a>
            </form>

            <!-- Bouton pour modifier le titre du sujet -->
            <a href="#" id="edit-link"><i class="uil uil-edit"></i></a>
        </div>

        <div>

            <?php 
            // On vérifie que l'utilisateur en session pour permettre ou non de répondre a un topic
            if((!isset($_SESSION["user"]))) { ?>
                <a href="index.php?ctrl=security&action=login">Répondre</a>
            <?php } else { ?>
                <a href="#">Répondre</a>
            <?php } ?>

            <?php 
            // On vérifie que l'utilisateur en session est soit un admin ou l'auteur du sujet pour permettre la suppression du topic
            if((App\Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) { ?>
                <?php 
                if($topic->getClosed() == 0) { ?>
                    <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">Vérrouiller</a>
                <?php } else { ?>
                    <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">Déverrouiller</a>
                <?php } ?>
            <?php } ?>



            <?php 
            // On vérifie que l'utilisateur en session est soit un admin ou l'auteur du sujet pour permettre la suppression du topic
            if((App\Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) { ?>
                <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Suppr. Topic</a>
            <?php } ?>

        </div>

    </div>

    <?php $nombrePosts = 0; ?>
        
    <?php foreach ($posts as $post) { 
        $nombrePosts++;
    ?>

    <div class="post-block">
        <div class="post-info">
            <figure>
                <img src="https://picsum.photos/50/50" alt="">
            </figure>
            <div class="user-date">
                <a href="index.php?ctrl=security&action=profile&id=<?= $post->getUser()->getId() ?>">
                    <?= $post->getUser() ?>
                </a>
                <p>Le <?= $post->getDatePost() ?></p>
            </div>
        </div>
        <p class="message-post"><?= htmlspecialchars_decode($post->getTexte()) ?></p>

        <?php 
            // On vérifie que l'utilisateur en session est soit un admin ou l'auteur du sujet pour permettre la suppression du topic
            if((App\Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId() )) { ?>
                <!-- Bouton modifier le post -->
                <a class="btn-edit-post" href="#">Modifier <i class="uil uil-edit"></i></a>
            <?php } ?>

        <!-- Formulaire modifier le post avec action vers la méthode editPost du controller -->
        <form class="edit-post" action="index.php?ctrl=forum&action=editPost&id=<?= $post->getId() ?>" method="post" enctype="multipart/form-date">
            <textarea class="post" type="text" name="texte"><?= $post->getTexte() ?></textarea>
            <input class="submit" type="submit" value="MODIFIER">
            <!-- Bouton pour annuler la modification en faisant display none sur le form et display block sur le post-text -->
            <a class="cancel-update-post" href="/">Annuler</a>
        </form>
        
        <!-- Affiche le bouton supprimer uniquement si $nombrePosts et supérieur a 1 -->
        <?php if ($nombrePosts > 1) { ?>

            <?php 
            // On vérifie que l'utilisateur en session est soit un admin ou l'auteur du sujet pour permettre la suppression d'un post
            if((App\Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId() )) { ?>
                <a class="btn-delete" href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">Supprimer</a>
            <?php } ?>
            
        <?php } ?>
    </div>
    <?php } ?>

    <?php 
        if((isset($_SESSION["user"])) && $topic->getClosed() == 0) { ?>

            <form  action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post" enctype="multipart/form-data">
                <label>Répondre</label>
                <textarea class="post" placeholder="Apporter une réponse au sujet.." name="text"></textarea>
                <input class="submit" type="submit" name="submit" value="POSTER">
            </form>

        <?php } elseif($topic->getClosed() == 1) { ?>

            <p>Ce sujet est vérrouiller, vous ne pouvez pas répondre</p>

        <?php } ?>

</div>