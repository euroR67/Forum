<?php
$categories = $result["data"]['categories'];
?>


<ul class="categorie-list">
    <h1>Liste des catégories</h1>
    <?php
foreach($categories as $categorie) {
    ?>
    <li>
        <a class="categorie-link" href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?=$categorie->getId()?>">
            <?=$categorie->getNomCategorie()?>
        </a>
        <?php 
        
        if(isset($_SESSION["user"]) && $_SESSION["user"]->hasRole("ROLE_ADMIN")) { ?>
            <!-- On fait apparaitre l'input qui permet de modifier le nom de la catégorie avec form -->
            <form class="update-cat-input" action="index.php?ctrl=forum&action=updateCategorie&id=<?=$categorie->getId()?>" method="post">
                <input type="text" name="nomCategorie" value="<?=$categorie->getNomCategorie()?>">
                <input type="submit" value="Modifier">
                <!-- Bouton pour annuler la modification en faisant display none sur le form et display block sur categorie-link -->
                <a class="cancel-update" href="/">Annuler</a>
            </form>

            <div class="update-delete">
                <!-- Bouton pour modifier le titre du catégorie -->
                <a class="update-categorie" href="index.php?ctrl=forum&action=updateCategorie&id=<?=$categorie->getId()?>">Modifier</a>
                <!-- Bouton pour supprimer la catégorie -->
                <a class="delete-categorie" href="index.php?ctrl=forum&action=deleteCategorie&id=<?=$categorie->getId()?>">Supprimer</a>
            </div>
        <?php } ?>

    </li>
    <?php } ?>

    <?php 
        if(isset($_SESSION["user"]) && $_SESSION["user"]->hasRole("ROLE_ADMIN")) { ?>
        <!-- Formulaire pour ajouter une nouvelle catégorie -->
        <form class="add-cat-form" action="index.php?ctrl=forum&action=addCategorie" method="post">
            <input type="text" name="nomCategorie" placeholder="Ajouter une catégorie">
            <input type="submit" value="Ajouter">
        </form>
    <?php } ?>
</ul>
