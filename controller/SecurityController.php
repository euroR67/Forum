<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    use Model\Managers\UserManager;
    
    class SecurityController extends AbstractController implements ControllerInterface {

        // Méthode pour s'inscrire
        public function register(){

            // On instancie le manager
            $userManager = new UserManager();

            if(isset($_POST["submit"])) {

                // On filtre les champs de saisis
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                // On vérifie que le filtrage c'est bien passée
                if($email && $pseudo && $password1 && $password2) {
                    // On vérifie si l'email ou pseudo existe ou non
                    if(!$userManager->findOneByEmail($email) && !$userManager->findOneByPseudo($pseudo)) {
                        // On vérifie que les 2 password correspondent et que le mdp contient au moins 8 caractères
                        if($password1 === $password2 ) {
                            // On vérifie que le mot de passe comporte plus de 8 caractères
                            if(strlen($password1) >= 8) {

                                // On hache le mot de passe avec BCRYPT (par défaut)
                                $password = password_hash($password1, PASSWORD_DEFAULT);
                                // On récupère les données du formulaire
                                $data = [
                                    'pseudo' => $pseudo ,
                                    'password' => $password,
                                    'role' => 'ROLE_USER',
                                    'email' => $email
                                ];
                                // On ajoute l'utilisateur a la base de donnée
                                $userManager -> add($data);

                                // Si inscription réussi on redirige vers la page login
                                $this->redirectTo("security", "login");

                            } else {
                                // Message ou action au cas ou le mot de passe est trop court
                                Session::addFlash("error", "Le mot de passe est trop court");
                            }
                        } else {
                            // Message ou action au cas ou le mot de passe n'est pas identique
                            Session::addFlash("error", "Les mots de passe ne sont pas identique");
                        }
                    } else {
                        // Message ou Action au cas ou l'utilisateur existe déjà
                        Session::addFlash("error", "Un utilisateur existe déjà avec cet email ou pseudo");
                    }
                } else {
                    // Message ou Action au cas ou le filtrage ne passe pas
                    Session::addFlash("error", "Vérifier vos saisis...");
                }
            }

            // On redirige vers la page d'inscription
            return [
                "view" => VIEW_DIR."security/register.php"
            ];

        }

        // Méthode pour ce connecter
        public function login(){

            // On instancie le manager
            $userManager = new UserManager();

            if(isset($_POST["submit"])) {

                // On filtre les champs de saisis
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // On vérifie que le filtrage c'est bien passée
                if($email && $password) {
                    // On récupère l'utilisateur en fonction de son email
                    $user = $userManager->findOneByEmail($email);
                    // On vérifie que l'utilisateur existe bien
                    if($user) {
                        // On compare le mot de passe
                        if(password_verify($password, $user->getPassword())) {
                            // On ouvre la session de l'utilisateur
                            Session::setUser($user);
                            // On redirige vers la liste des catégories
                            $this->redirectTo("forum", "listCategories");
                        } else {
                            // Message ou action si le mot de passe est incorrect
                            Session::addFlash("error", "Email ou mot de passe incorrect");
                        }
                    } else {
                    // Message si le comtpe n'existe pas
                    Session::addFlash("error", "Aucun compte existant avec cet email");
                    }
                } else {
                    // Message ou action au cas ou le filtrage n'est pas passé
                    Session::addFlash("error", "Vérifier vos saisis...");
                }
            }

            // On redirige vers la page de login
            return [
                "view" => VIEW_DIR."security/login.php"
            ];

        }

        // Fonction pour ce déconnecter de la session
        public function logOut() {

            // On retire la session utilisateur (user)
            unset($_SESSION["user"]);
            // On redirige vers la liste des catégorie (home) une fois déconnecter
            $this->redirectTo("forum", "listCategories");

        }

        // Fonction pour récupérer les information d'un utilisateur et envoyer a la vue profile.php
        public function profile($id = NULL) {

            // On instancie les managers
            $userManager = new UserManager();
            $postManager = new PostManager();

            // On vérifie qu'il s'agit bien du profil de la personne connecter
            // Si oui on affiche le profile de l'utilisateur connecter
            if($id == NULL) {
                // On récupère l'id de l'utilisateur en session
                $idUser = $_SESSION["user"]->getId();
                // On récupère l'utilisateur et l'envoie à la vue
                return [
                    "view" => VIEW_DIR."security/profile.php",
                    "data" => [
                        "posts" => $postManager->findPostsByUser($idUser),
                        "user" => $userManager->findOneById($idUser)
                    ]
                ];
            // Sinon on affiche le profile des utilisateurs par leur ID
            } else {
                return [
                    "view" => VIEW_DIR."security/profile.php",
                    "data" => [
                        "posts" => $postManager->findPostsByUser($id),
                        "user" => $userManager->findOneById($id)
                    ]
                ];
            }
            

        }

    }

?>