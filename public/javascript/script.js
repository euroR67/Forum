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
    
    // On vérifie si l'élément editLink existe avant d'attacher l'écouteur d'événements
    if (editLink) {
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
}

updateTitle();


    function updatePost() {
        // Sélectionnez tous les boutons "Modifier le post"
        const btnEditPosts = document.querySelectorAll(".btn-edit-post");
        const cancelUpdatePosts = document.querySelectorAll(".cancel-update-post");
    
        for (let i = 0; i < btnEditPosts.length; i++) {
            btnEditPosts[i].addEventListener("click", function (e) {
                e.preventDefault();
    
                // Trouvez le post correspondant à ce bouton
                const postBlock = btnEditPosts[i].closest(".post-block");
                const postText = postBlock.querySelector(".message-post");
                const editPostForm = postBlock.querySelector(".edit-post");
    
                // Sélectionnez également le bouton "Modifier" pour le masquer
                const btnEdit = postBlock.querySelector(".btn-edit-post");
    
                // Masquez le bouton "Modifier", le texte du post et affichez le formulaire d'édition
                btnEdit.style.display = "none";
                postText.style.display = "none";
                editPostForm.style.display = "block";
            });
    
            cancelUpdatePosts[i].addEventListener("click", function (e) {
                e.preventDefault();
    
                // Trouvez le post correspondant à ce bouton
                const postBlock = cancelUpdatePosts[i].closest(".post-block");
                const postText = postBlock.querySelector(".message-post");
                const editPostForm = postBlock.querySelector(".edit-post");
    
                // Sélectionnez également le bouton "Modifier" pour le réafficher
                const btnEdit = postBlock.querySelector(".btn-edit-post");
    
                // Réaffichez le bouton "Modifier", le texte du post et masquez le formulaire d'édition
                btnEdit.style.display = "unset";
                postText.style.display = "block";
                editPostForm.style.display = "none";
            });
        }
    }
    
    updatePost();
    
    function banUser() {
        // On récupère tout les boutons bannir
        let banButtons = document.querySelectorAll("button");

        // On boucle sur tout les boutons bannir
        banButtons.forEach(banButton => {

            // On ajoute un event listener sur chaque bouton bannir
            banButton.addEventListener("click", function() {

                // On récupère le form juste après le bouton bannir
                let form = banButton.nextElementSibling;

                // On affiche le form
                form.style.display = "block";

                // On cache le bouton bannir
                banButton.style.display = "none";

            })

        })
    }

    banUser();


});