<?php
  $categories = $result["data"]['categories'];
?>

<div class="main-home">
  <div class="logo">
      <h1>CDA</h1>
  </div>

  <div class="welcome">
      <h2>Bienvenue</h2>
      <h2>sur "CDA" FORUM</h2>
      <p>Le tout nouveau forum du net!</p>

      <div class="search-container">
        <input type="text" placeholder="Entrée un mot clé.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
      </div>
  </div>
  
  <?php if(!App\Session::getUser()) { ?>
    <div class="join-us">
      <h3>REJOIGNEZ NOTRE FORUM !</h3>
      <p>Parlez de tout ce qui vous passe par la tête et voyez ce que pensent les autres. En tant qu'invité de notre forum, vous ne pouvez consulter que les messages. Lorsque vous vous inscrivez sur le forum Forumix, vous pouvez participer à des sujets, créer de nouveaux sujets et généralement faire partie du premier niveau de notre communauté.</p>
      <a href="index.php?ctrl=security&action=register">S'INSCRIRE !</a>
    </div>
    <?php } ?>

  <div class="forums">
      <h3>FORUMS</h3>
      <ul>
        <?php
          foreach($categories as $categorie) { ?>
              <li>
                  <a class="categorie-link" href="index.php?ctrl=forum&action=listTopicsByCategorie&id=<?=$categorie->getId()?>">
                      <?=$categorie->getNomCategorie()?>
                  </a>
                  <p>Ici la description de la catégorie du forum, placeholder etc..</p>
              </li>
          <?php } ?>
      </ul>
  </div>
</div>


