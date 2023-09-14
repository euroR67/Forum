<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?= PUBLIC_DIR ?>/javascript/script.js"></script>
    <title>FORUM</title>
</head>
<body>
    <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
    <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
    <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
    <header>
        <div class="bars">
            <i class="fa-solid fa-bars"></i>
            <span>MENU</span>
        </div>
        <nav>
            <h2>CDA Forum</h2>
            <ul>
                <li><a href="index.php?ctrl=forum&action=listCategoriesHome"><i class="fa-solid fa-house"></i> Accueil</a></li>
                <?php
                if(App\Session::getUser()){ ?>
                    <li><a href="index.php?ctrl=forum&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a></li>
                    <li><a href="index.php?ctrl=forum&action=listCategories"><i class="fa-solid fa-list"></i> Forums</a></li>
                    <?php
                    if(App\Session::isAdmin()) { ?>
                        <li><a href="index.php?ctrl=admin&action=usersList"><i class="fa-solid fa-users"></i> Membres</a></li>
                    <?php } ?>
                    <li><a href="#"><i class="fa-solid fa-envelope"></i> Contact</a></li>
                    <li><a href="index.php?ctrl=security&action=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></i> Déconnexion</a></li>
                    <?php }
                else{ ?>
                    <li><a href="index.php?ctrl=forum&action=listCategories"><i class="fa-solid fa-list"></i> Forums</a></li>
                    <li class="login-signin"><a href="index.php?ctrl=security&action=login"><i class="fa-solid fa-arrow-right-to-bracket"></i> Connexion</a></li>
                    <li class="login-signin"><a href="index.php?ctrl=security&action=register"><i class="fa-regular fa-registered"></i> Inscription</a></li>
                    <li><a href="#"><i class="fa-solid fa-envelope"></i> Contact</a></li>
                <?php } ?>
            </ul>
        </nav>
        <?php
                if(App\Session::getUser()){ ?>
                    <a href="index.php?ctrl=forum&action=profile"><i class="fas fa-user"></i></a>
                <?php } else { ?>
                    <a href="index.php?ctrl=security&action=login"><i class="fas fa-user"></i></a>
                <?php } ?>
        <div class="overlay"></div>
    </header>
    

    <script>

        // Script pour le menu slide version mobile

        // On récupère les éléments du DOM
        const bars = document.querySelector(".bars")
        const nav = document.querySelector("nav")
        const overlay = document.querySelector(".overlay")

        // On écoute l'événement click sur l'élément bars
        bars.addEventListener("click", function(){
            // On ajoute la classe active à nav
            nav.classList.add("active")
            // On ajoute la classe active à overlay
            overlay.classList.add("active-overlay")
            // Lorsque l'on clique sur overlay, on retire la classe active à nav et overlay
            overlay.addEventListener("click", function(){
                nav.classList.remove("active")
                overlay.classList.remove("active-overlay")
            })
            // Si la navbar active on désactive le scroll
            if(nav.classList.contains("active")){
                document.body.style.overflow = "hidden"
            }
            else{
                document.body.style.overflow = "auto"
            }
        })

    </script>
    
    <main id="forum">
        <?= $page ?>
    </main>

    <footer>
        <p>© 2023 - Forum CDA - <br><a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a></p><br>
        <p>Made by <i class="fa-brands fa-linkedin"></i> <a href="https://www.linkedin.com/in/mansour-chamaev">Mansour Chamaev</a></p>
        <div class="social">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-github"></i></a>
        </div>
    </footer>

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    <script>

        $(document).ready(function(){
            $(".message").each(function(){
                if($(this).text().length > 0){
                    $(this).slideDown(500, function(){
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function(){
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })

    </script>
</body>
</html>