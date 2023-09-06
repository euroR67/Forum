<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    
    class SecurityController extends AbstractController implements ControllerInterface {

        // Méthode pour s'inscrire
        public function register(){

            // On instancie le manager
            $userManager = new UserManager();

            // On filtre les champs de saisis
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // On vérifie que le filtrage c'est bien passée
            if($email && $pseudo && $password1 && $password2 
            && !$userManager->findOneByEmail($email) 
            && !$userManager->findOneByPseudo($pseudo)) {
                var_dump("ok");die;
                
            } else {
                // Message ou Action au cas ou le filtrage ne passe pas
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

            // On redirige vers la page de login
            return [
                "view" => VIEW_DIR."security/login.php"
            ];

        }

    }

?>