<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];

?>

<div class="main-topics">
    <div class="logo">
        <h1>CDA</h1>
    </div>
    <div class="welcome">
        <h2><?= $categories->getNomCategorie() ?></h2>
        <p>Ici on donne un bref détail de la catégorie</p>

        <div class="search-container">
            <input type="text" placeholder="Rechercher un sujet.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div>

<div class="file-ariane">
    <h2>
        <a href="index.php?ctrl=forum&action=listCategoriesHome"><i class="fa-solid fa-house"></i></a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> <i class="fa-solid fa-chevron-right"></i>
        <?=$categories->getNomCategorie()?>
    </h2>
</div>


<div class="topics-container">

    <?php
    // On vérifie qu'une session est en cours et que l'utilisateur n'est pas banni
    if((isset($_SESSION["user"])) && ($_SESSION["user"]->getBannedUntil() == NULL)) { ?>
        <div class="btn-add">
            <a class="nv_sujet" href="#">Nouveau Sujet</a>
        </div>
    <?php } ?>

<?php
if (empty($topics)) : ?>
    <p>Aucun sujet n'a été trouvé dans cette catégorie.</p>
<?php else : ?>
        <table border=1>
            <tr>
                <th>SUJET</th>
                <th><i class="fa-solid fa-comments"></i></th>
                <th class="mobile-none">Dernier msg</th>
            </tr>
            <?php foreach($topics as $topic) : ?>
                <tr>
                    <td>
                        <a class="topic-title" href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                            <?= $topic->getTitre() ?>
                        </a>
                        <!-- On affiche le pseudo si l'utilisateur existe sinon on affiche utilisateur supprimée -->
                        <?php if ($topic->getUser()): ?>
                            <p class="madeby">Crée par : 
                            <a class="author" href="index.php?ctrl=forum&action=profile&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser()->getPseudo() ?></a>
                            </p>
                        <?php else: ?>
                            <p>Utilisateur supprimé</p>
                        <?php endif; ?>
                    </td>
                    
                    <td class="nb-post"><?= $topic->getNbPosts() ?></td>
                    <td class="mobile-none">
                    <?php
                        $lastPostDateStr = $topic->getLastPostDate(); // Récupérer la date du dernier post au format chaîne

                        // Convertir la date du dernier post en objet DateTime avec un format spécifique
                        $lastPostDate = DateTime::createFromFormat('d/m/Y, H:i:s', $lastPostDateStr);
                        $currentDate = new DateTime();

                        if ($lastPostDate !== false) { // Vérifier si la conversion a réussi
                            if ($lastPostDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                                ?>
                                <p><?= $lastPostDate->format('H:i:s') ?></p>
                                <?php
                            } else {
                                ?>
                                <p><?= $lastPostDate->format('d/m/Y') ?></p>
                                <?php
                            }
                        } else {
                            echo "Date invalide"; // En cas de conversion échouée
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    <div class="file-ariane">
        <p>Vous devez être connecter pour créer un nouveau sujet.</p>
    </div>
    <?php 
    // On vérifie que l'utilisateur en session pour permettre ou non la création d'un nouveau topic
    if((isset($_SESSION["user"])) && ($_SESSION["user"]->getBannedUntil() == NULL)) { ?>
        <!-- Formulaire pour ajouter un nouveau sujet et le premier post -->
        <form action="index.php?ctrl=forum&action=ajoutSujet&id=<?= $categories->getId() ?>" method="post" enctype="multipart/form-date">
            <label>Nouveau sujet</label>
            <input class="champ-titre" type="text" name="titre" placeholder="Titre du sujet">
            <textarea placeholder="Apporter une réponse au sujet.." name="text"></textarea>
            <input class="submit" type="submit" name="submit" value="POSTER">
        </form>
    <?php } ?>