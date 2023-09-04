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
                <input type="text" name="titre" id="new-title" value="<?= $topic->getTitre() ?>">
                <input type="submit" value="Modifier">
                <!-- Bouton pour annuler la modification en faisant display none sur le form et display block sur topic-title -->
                <a class="cancel-update" href="/">Annuler</a>
            </form>

            <!-- Bouton pour modifier le titre du sujet -->
            <a href="#" id="edit-link"><i class="uil uil-edit"></i></a>

        </div>
        <form id="edit-form" style="display: none;">
            <input type="text" id="new-title" placeholder="Nouveau titre">
            <input type="submit" value="Valider">
        </form>

        <div>
            <a href="#">Répondre</a>
            <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
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
                <a href="#">
                    <?= $post->getUser() ?>
                </a>
                <p>Le <?= $post->getDatePost() ?></p>
            </div>
        </div>
        <p><?= $post->getTexte() ?></p>
        <!-- Affiche le bouton supprimer uniquement si $nombrePosts et supérieur a 1 -->
        <?php if ($nombrePosts > 1) { ?>
            <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>">SUPPRIMER</a>
        <?php } ?>
    </div>
    <?php } ?>
    <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="post" enctype="multipart/form-date">
        <label>Répondre</label>
        <textarea placeholder="Apporter une réponse au sujet.." name="text"></textarea>
        <input class="submit" type="submit" name="submit" value="POSTER">
    </form>
</div>

<script>

    // On récupère l'id du bouton pour modifier le titre du sujet
    const editLink = document.getElementById("edit-link");
    // On récupère l'id du titre du sujet
    const topicTitle = document.getElementById("topic-title");
    // On récupère l'id du form pour modifier le titre du sujet
    const editForm = document.getElementById("edit-form");
    // On récupère l'id du nouvel input pour modifier le titre du sujet
    const newTitle = document.getElementById("new-title");
    // On récupère l'id du bouton pour annuler la modification du titre du sujet
    const cancelUpdate = document.querySelector(".cancel-update");

    // On fait apparaitre l'input qui permet de modifier le titre du sujet
    editLink.addEventListener("click", function(e) {
        e.preventDefault();
        topicTitle.style.display = "none";
        editForm.style.display = "block";
    });

    // On fait disparaitre l'input qui permet de modifier le titre du sujet
    cancelUpdate.addEventListener("click", function(e) {
        e.preventDefault();
        topicTitle.style.display = "block";
        editForm.style.display = "none";
    });

</script>