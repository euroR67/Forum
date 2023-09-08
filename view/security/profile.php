<?php 
    $users = $result["data"]["user"];
    $posts = $result["data"]["posts"];
?>

<h1>Profile</h1>

<!-- On informe l'utilisateur si son compte est banni et jusqu'à quand -->
<?php if($users->getBannedUntil() !== NULL) { ?>

    <p style="color: red;">Vous êtes banni jusqu'au <?= $users->getBannedUntil() ?></p>

    <!-- On informe l'utilisateur que l'accès au fonctionnalité du site est limité pendant son ban -->
    <p style="color: red;">L'accès a certaines fonctionnalité du forum vous est limité durant votre ban</p>

<?php } ?>

<p>Pseudo : <?= $users->getPseudo() ?></p>
<p>Date d'inscription : <?= $users->getDateInscription() ?></p>
<p>Pseudo : <?= $users->getRole() ?></p>

<!-- On affiche l'email uniquement si c'est l'email de l'utilisateur connecté (en session) -->
<?php if($users->getId() == $_SESSION['user']->getId()) { ?>

    <p>Email : <?= $users->getEmail() ?></p>

<?php } ?>

<h2>Dernier posts</h2>

<?php if(empty($posts)) : ?>
    <p>Vous avez 0 post</p>
    <?php else : ?>
        <?php foreach($posts as $post) : { ?>
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
        <p class="message-post"><?= htmlspecialchars_decode($post->getTexte()) ?></p>
        <a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $post->getTopic()->getId() ?>">Aller au sujet</a>
    </div>
        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>


