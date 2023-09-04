// Utilisez l'événement "DOMContentLoaded" pour attendre que la page soit complètement chargée
document.addEventListener("DOMContentLoaded", function() {
    // On utilise JavaScript pour permettre à l'utilisateur de modifier le titre de la catégorie
    const updateCategorie = document.querySelectorAll(".update-categorie");
    const categorieLink = document.querySelectorAll(".categorie-link");
    const updateCatInput = document.querySelectorAll(".update-cat-input");
    const cancelUpdate = document.querySelectorAll(".cancel-update");

    // On créer la fonction qui va faire disparaitre le lien "categorie-link" et faire apparaitre l'input
    // "update-cat-input" , et lorsqu'on clique sur cancel-update, on fait disparaitre l'input et on fait
    // apparaitre le lien
    function updateCat() {
        for (let i = 0; i < updateCategorie.length; i++) {
            updateCategorie[i].addEventListener("click", function(e) {
                e.preventDefault();
                categorieLink[i].style.display = "none";
                updateCatInput[i].style.display = "block";
            });
            cancelUpdate[i].addEventListener("click", function(e) {
                e.preventDefault();
                categorieLink[i].style.display = "block";
                updateCatInput[i].style.display = "none";
            });
        }
    }

    // On appelle la fonction
    updateCat();
    
    // On utilise JavaScript pour permettre à l'utilisateur de modifier le titre du sujet
    function updateTitle() {
        // On récupère l'id du bouton pour modifier le titre du sujet
        const editLink = document.getElementById("edit-link");
        // On récupère l'id du titre du sujet
        const topicTitle = document.getElementById("topic-title");
        // On récupère l'id du form pour modifier le titre du sujet
        const editForm = document.getElementById("edit-form");
        // On récupère l'id du bouton pour annuler la modification du titre du sujet
        const cancelUpdateTitle = document.querySelector(".cancel-update-title");
    
        // On fait apparaitre l'input qui permet de modifier le titre du sujet
        editLink.addEventListener("click", function(e) {
            e.preventDefault();
            topicTitle.style.display = "none";
            editForm.style.display = "block";
        });
    
        // On fait disparaitre l'input qui permet de modifier le titre du sujet
        cancelUpdateTitle.addEventListener("click", function(e) {
            e.preventDefault();
            topicTitle.style.display = "block";
            editForm.style.display = "none";
        });
    }
    updateTitle();

    // On utilise JavaScript pour permettre à l'utilisateur de modifier le post
    function updatePost() {
        // on récupère l'id du bouton pour modifier le post
        const btnEditPost = document.querySelector(".btn-edit-post");
        // on récupère l'id du form pour modifier le post
        const editPost = document.querySelector(".edit-post");
        // on récupère l'id du post
        const postText = document.querySelector(".message-post");
        // on récupère l'id du bouton pour annuler la modification du post
        const cancelUpdatePost = document.querySelector(".cancel-update-post");

        // On fait apparaitre l'input qui permet de modifier le post , on fait disparaitre le post et le bouton modifier
        btnEditPost.addEventListener("click", function(e) {
            e.preventDefault();
            postText.style.display = "none";
            btnEditPost.style.display = "none";
            editPost.style.display = "block";
        });

        // On fait disparaitre l'input qui permet de modifier le post , on fait apparaitre le post et le bouton modifier
        cancelUpdatePost.addEventListener("click", function(e) {
            e.preventDefault();
            postText.style.display = "block";
            btnEditPost.style.display = "block";
            editPost.style.display = "none";
        });
    }
    updatePost();

});