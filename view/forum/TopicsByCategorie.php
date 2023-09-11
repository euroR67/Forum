<?php

$topics = $result["data"]['topics'];
$categories = $result["data"]['categories'];

?>

<h1> <a href="index.php?ctrl=forum&action=listCategories">Catégories</a> > <?=$categories->getNomCategorie()?></h1>


<div class="topics-container">

    <?php
    // On vérifie qu'une session est en cours et que l'utilisateur n'est pas banni
    if((isset($_SESSION["user"])) && ($_SESSION["user"]->getBannedUntil() == NULL)) { ?>
        <div class="btn-add">
            <a class="nv_sujet" href="#">Nouveau Sujet</a>
        </div>
        <!-- Si non si l'utilisateur est pas banni ou que aucune session n'est en cours -->
    <?php } elseif((!isset($_SESSION["user"])) || ($_SESSION["user"]->getBannedUntil() == NULL)) { ?>
        <div class="btn-add">
            <a class="nv_sujet" href="index.php?ctrl=security&action=login">Nouveau Sujet</a>
        </div>
    <?php } ?>

<?php
if (empty($topics)) : ?>
    <p>Aucun sujet n'a été trouvé dans cette catégorie.</p>
<?php else : ?>
        <table border=1>
            <tr>
                <th>Sujet</th>
                <th>Auteur</th>
                <th>NB Mess</th>
                <th>Dernier msg</th>
            </tr>
            <?php foreach($topics as $topic) : ?>
                <tr>
                    <td>
                        <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>">
                            <?= $topic->getTitre() ?>
                        </a>
                    </td>
                    <td>
                        <!-- On affiche le pseudo si l'utilisateur existe sinon on affiche utilisateur supprimée -->
                        <?php if ($topic->getUser()): ?>
                            <a href=""><?= $topic->getUser()->getPseudo() ?></a>
                        <?php else: ?>
                            <p>Utilisateur supprimé</p>
                        <?php endif; ?>

                    </td>
                    <td><?= $topic->getNbPosts() ?></td>
                    <td>
                        <?php
                            $lastPostDateStr = $topic->getLastPostDate(); // Récupérer la date du dernier post au format chaîne
                            
                            // Convertir la date du dernier post en objet DateTime avec un format spécifique
                            $lastPostDate = DateTime::createFromFormat('d/m/Y, H:i:s', $lastPostDateStr);
                            $currentDate = new DateTime();
                            
                            if ($lastPostDate !== false) { // Vérifier si la conversion a réussi
                                if ($lastPostDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                                    echo $lastPostDate->format('H:i:s');
                                } else {
                                    echo $lastPostDate->format('d/m/Y');
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