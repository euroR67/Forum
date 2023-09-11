<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    use Model\Managers\UserManager;
    
    class AdminController extends AbstractController implements ControllerInterface {

        
        // Fonction pour récupérer tout les utilisateurs et envoyer a la vue listUsers.php
        public function usersList(){

            // On vérifie que l'utilisateur est en session et qu'il est admin pour accéder a la vue listUsers.php
            if(!Session::isAdmin()) {
                // Message ou action si l'utilisateur n'est pas admin
                Session::addFlash("error", "Vous n'êtes pas autorisé a accéder a cette page");
                // On redirige vers la liste des catégories
                $this->redirectTo("forum", "listCategories");
            }

            // On instancie les managers
            $userManager = new UserManager();

            // On récupère les utilisateurs et on les envoie à la vue
            return [
                "view" => VIEW_DIR."security/listUsers.php",
                "data" => [
                    "users" => $userManager->findAll(["pseudo", "ASC"])
                ]
            ];

        }

        // Fonction pour bannir un utilisateur pour une durée déterminé en récupérant la date fourni par l'input type date
        public function banUser($id) {

            // On vérifie que l'utilisateur est connecté et est admin
            if(!Session::isAdmin()){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour ban un utilisateur");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie le manager
            $userManager = new UserManager();

            // On récupère la date fourni par l'input type date
            $bannedUntil = $_POST["bannedUntil"];
            // On banni l'utilisateur
            $userManager->banUser($id, $bannedUntil);

            // Message flash si l'utilisateur est banni sinon message erreur
            if($bannedUntil) {
                Session::addFlash("success", "L'utilisateur a été banni jusqu'au $bannedUntil");
            } else {
                Session::addFlash("error", "L'utilisateur n'a pas été banni");
            }

            // On redirige vers la liste des utilisateurs
            $this->redirectTo("admin", "usersList");

        }

        // Fonction pour débannir un utilisateur
        public function unbanUser($id) {

            // On vérifie que l'utilisateur est connecté et est admin
            if(!Session::isAdmin()){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour débannir un utilisateur");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }
            // On instancie le manager
            $userManager = new UserManager();

            // On débanni l'utilisateur
            $userManager->unbanUser($id);

            // Message flash si l'utilisateur est débanni sinon message erreur
            if($id) {
                Session::addFlash("success", "L'utilisateur a été débanni");
            } else {
                Session::addFlash("error", "L'utilisateur n'a pas été débanni");
            }

            // On redirige vers la liste des utilisateurs
            $this->redirectTo("admin", "usersList");

        }


    }