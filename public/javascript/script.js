// Utilisez l'événement "DOMContentLoaded" pour attendre que la page soit complètement chargée
document.addEventListener("DOMContentLoaded", function() {
    // On utilise JavaScript pour faire disparaitre le lien "categorie-link" et faire apparaitre l'input 
    // "update-cat-input" au clic sur le lien "update-categorie"
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
    
});