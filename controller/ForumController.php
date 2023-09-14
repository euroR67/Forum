<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategorieManager;
    use Model\Managers\UserManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          

            // On instancie le manager
           $topicManager = new TopicManager();

           // On récupère les topics et on les envoie à la vue
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateTopic", "DESC"])
                ]
            ];
        
        }

        // Méthode pour récupérer les catégories et les envoyer à la vue
        public function listCategories(){

            // On instancie le manager
            $categorieManager = new CategorieManager();

            // On récupère les catégories et on les envoie à la vue
            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categorieManager->findAll(["nomCategorie", "ASC"])
                ]
            ];

        }

        // Méthode pour récupérer les catégories et les envoyer à la vue
        public function listCategoriesHome(){

            // On instancie le manager
            $categorieManager = new CategorieManager();

            // On récupère les catégories et on les envoie à la vue
            return [
                "view" => VIEW_DIR."home.php",
                "data" => [
                    "categories" => $categorieManager->findAll(["nomCategorie", "ASC"])
                ]
            ];

        }
        
        // Méthode pour récupérer les topics d'une catégorie et les envoyer à la vue
        public function listTopicsByCategorie($id) {

            // On instancie les managers
            $topicManager = new TopicManager();
            $categorieManager = new CategorieManager();

            // On récupère les topics et la catégorie et on les envoie à la vue
            return [
                "view" => VIEW_DIR."forum/TopicsByCategorie.php",
                "data" => [
                    "topics" => $topicManager->findTopicsByCategorie($id,["dateTopic", "ASC"]),
                    "categories" => $categorieManager->findOneById($id)
                ]
            ];

        }

        // Méthode pour récupérer les posts d'un topic et les envoyer à la vue du topic
        public function listPostsByTopic($id) {

            // On instancie les managers
            $postManager = new PostManager();
            $topicManager = new TopicManager();

            // On récupère les posts et le topic et on les envoie à la vue
            return [
                "view" => VIEW_DIR."forum/PostsByTopics.php",
                "data" => [
                    // On appelle la méthode findPostsByTopic() du PostManager pour récupérer les posts d'un topic
                    "posts" => $postManager->findPostsByTopic($id, ["datePost", "ASC"]),
                    // On appelle la méthode findOneById() du TopicManager pour récupérer le topic
                    "topic" => $topicManager->findOneById($id)
                ]
            ];

        }

        // Méthode pour ajouter un post
        public function addPost($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour poster un message");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie le manager
            $postManager = new PostManager();
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
           // On récupère les données du formulaire
            $data = [
                'texte'=> $text ,
                'user_id'=> $_SESSION["user"]->getId(),
                'topic_id'=> $id
            ];

            // On ajoute le post
            $postManager->add($data);

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($postManager){
                Session::addFlash("success", "Votre message a bien été ajouté");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de l'ajout de votre message");
            }

            // On redirige vers la page du topic
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }

        // Méthode pour suppimer un post sauf si c'est le premier post du topic avec findFirstPostByTopic()
        public function deletePost($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour supprimer un message");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $postManager = new PostManager();

            // On récupère l'id du topic du post
            $post = $postManager->findOneById($id);
            $idTopic = $post->getTopic()->getId();
            
            // On récupère l'id du premier post du topic
            $firstPost = $postManager->findFirstPostByTopic($idTopic);
           
            $idFirstPost = $firstPost->getId();

            // On vérifie que l'action est effectuer par un admin ou l'auteur du post
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId() )) {
                // Si l'id du post est différent de l'id du premier post du topic, on supprime le post
                if($id != $idFirstPost){
                    $postManager->delete($id);
                }
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $idTopic);
            }

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($postManager){
                Session::addFlash("success", "Votre message a bien été supprimé");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la suppression de votre message");
            }

            // On redirige vers la page du topic
            $this->redirectTo("forum", "listPostsByTopic", $idTopic);

        }

        // Méthode pour supprimer un sujet et tous les posts associés
        public function deleteTopic($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour supprimer un topic");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $topicManager = new TopicManager();

            // On récupère l'id du topic
            $topic = $topicManager->findOneById($id);
            $idTopic = $topic->getId();

            // On vérifie que l'action est effectuer par un admin ou l'auteur du post
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) {
                // On supprime le sujet et tous les posts associés
                $topicManager->delete($idTopic);
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $idTopic);
            }
            
            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($topicManager){
                Session::addFlash("success", "Votre sujet a bien été supprimé");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la suppression de votre sujet");
            }

            // On redirige vers la liste des topics de la catégorie du sujet supprimé
            $this->redirectTo("forum", "listTopicsByCategorie", $topic->getCategorie()->getId());
            

        }

        // Méthode pour ajouter un sujet et un premier post
        public function ajoutSujet($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour créer un nouveau sujet");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            
            // On récupère les données du formulaire et on les filtre pour éviter les injections
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // On ajoute le sujet et on récupère l'id du sujet
            $newTopicId = $topicManager->add([
                "titre" => $titre,
                "user_id" => $_SESSION["user"]->getId(),
                "categorie_id" => $id]);

            // On ajoute le premier post dans le sujet avec l'id du sujet récupéré
            $postManager->add([
                "texte" => $text,
                "user_id" => $_SESSION["user"]->getId(),
                "topic_id" => $newTopicId]);
            
            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($topicManager && $postManager){
                Session::addFlash("success", "Votre sujet a bien été ajouté");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de l'ajout de votre sujet");
            }

            // On redirige vers la page du sujet créé via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $newTopicId);
        }

        // Méthode pour modifier le nom d'une catégorie
        public function updateCategorie($id){
            // On vérifie que l'utilisateur est connecté et est admin
            if(!Session::isAdmin()){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour modifier une catégorie");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }
            // On instancie les managers
            $categorieManager = new CategorieManager();

            // On récupère le nouveau nom de la catégorie
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On modifie le nom de la catégorie
            $categorieManager->updateCategorie($id,$nomCategorie);

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($categorieManager){
                Session::addFlash("success", "Votre catégorie a bien été modifiée");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la modification de votre catégorie");
            }

            // On redirige vers la liste des catégories
            $this->redirectTo("forum", "listCategories");

        }

        // Méthode pour ajouter une catégorie 
        public function addCategorie(){
            // On vérifie que l'utilisateur est connecté et est admin
            if(!Session::isAdmin()){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour créer une catégorie");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $categorieManager = new CategorieManager();

            // On récupère le nom de la catégorie
            $nomCategorie = filter_input(INPUT_POST, 'nomCategorie', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On ajoute la catégorie
            $categorieManager->add([
                "nomCategorie" => $nomCategorie]);

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($categorieManager){
                Session::addFlash("success", "Votre catégorie a bien été ajoutée");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de l'ajout de votre catégorie");
            }

            // On redirige vers la liste des catégories
            $this->redirectTo("forum", "listCategories");

        }

        // Méthode pour supprimer une catégorie et tous les topics et posts associés
        public function deleteCategorie($id){
            // On vérifie que l'utilisateur est connecté et est admin
            if(!Session::isAdmin()){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté en tant qu'administrateur pour supprimer une catégorie");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $categorieManager = new CategorieManager();

            // On récupère l'id de la catégorie
            $categorie = $categorieManager->findOneById($id);
            $idCategorie = $categorie->getId();

            // On supprime la catégorie et tous les topics et posts associés
            $categorieManager->delete($idCategorie);

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($categorieManager){
                Session::addFlash("success", "Votre catégorie a bien été supprimée");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la suppression de votre catégorie");
            }

            // On redirige vers la liste des catégories
            $this->redirectTo("forum", "listCategories");

        }

        // Méthode pour modifier le titre d'un sujet
        public function editTopicTitle($id){
            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour modifier un sujet");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $topicManager = new TopicManager();

            // On récupère l'id du topic
            $topic = $topicManager->findOneById($id);

            // On récupère le nouveau titre du sujet
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On vérifie que l'action est effectuer par un admin ou l'auteur du topic
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) {
                // On modifie le titre du sujet
                $topicManager->updateTopic($id, $titre);
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $id);
            }

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($topicManager){
                Session::addFlash("success", "Votre sujet a bien été modifié");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la modification de votre sujet");
            }

            // On redirige vers la page du sujet modifié via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }

        public function editPost($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour modifier un post");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie les managers
            $postManager = new PostManager();
        
            // On récupère l'id du topic du post
            $post = $postManager->findOneById($id);
            $idPost = $post->getTopic()->getId();
        
            // On récupère le nouveau texte du post
            $texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            // Obtenez l'ID de l'utilisateur ou de l'administrateur actuel
            $modifiedBy = (isset($_SESSION["user"])) ? $_SESSION["user"]->getPseudo() : null;
        
            // On vérifie que l'action est effectuer par un admin ou l'auteur du post
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $post->getUser()->getId() )) {
                // On modifie le texte du post
                $postManager->updatePost($id, $texte, $modifiedBy);
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $idPost);
            }

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($postManager){
                Session::addFlash("success", "Votre message a bien été modifié");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la modification de votre message");
            }
            
            // Redirigez vers la page du sujet modifié via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $idPost);
        }
        

        // Fonction pour vérrouiller un topic
        public function lockTopic($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour vérrouiller un sujet");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie le manager
            $topicManager = new TopicManager();

            // On récupère l'id du topic
            $topic = $topicManager->findOneById($id);

            // On vérifie que l'action est effectuer par un admin ou l'auteur du topic
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) {
                // On modifie le status verrouiller en TRUE
                $topicManager->lockTopic($id);
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $id);
            }

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($topicManager){
                Session::addFlash("success", "Votre sujet a bien été vérrouillé");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la vérrouillage de votre sujet");
            }

            // On redirige vers la page du sujet modifié via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }

        // Fonction pour vérrouiller un topic
        public function unlockTopic($id){

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté pour déverrouiller un sujet");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }

            // On instancie le manager
            $topicManager = new TopicManager();

            // On récupère l'id du topic
            $topic = $topicManager->findOneById($id);

            // On vérifie que l'action est effectuer par un admin ou l'auteur du topic
            if((Session::isAdmin())
            || (isset($_SESSION["user"]) && $_SESSION["user"]->getId() == $topic->getUser()->getId() )) {
                // On modifie le status verrouiller en FALSE
                $topicManager->unlockTopic($id);
            } else {
                // On redirige vers la page du topic
                $this->redirectTo("forum", "listPostsByTopic", $id);
            }

            // Message flash pour confirmer l'ajout du post si réussi sinon message d'erreur
            if($topicManager){
                Session::addFlash("success", "Votre sujet a bien été déverrouillé");
            } else {
                Session::addFlash("error", "Une erreur est survenue lors de la déverrouillage de votre sujet");
            }

            // On redirige vers la page du sujet modifié via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $id);

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

        // Fonction pour supprimer un utilisateur
        public function deleteUser($id) {

            // On vérifie que l'utilisateur est connecté
            if(!isset($_SESSION["user"])){
                // On enregistre un message flash
                Session::addFlash("error", "Vous devez être connecté supprimer votre compte");
                // On redirige vers la page de connexion
                $this->redirectTo("security", "login");
            }
            // On instancie le manager
            $userManager = new UserManager();

            // On vérifie que l'action est effectué par un admin ou par le propriétaire du compte
            if(Session::isAdmin() || $_SESSION["user"]->getId() == $id) {
                // On supprime l'utilisateur
                $userManager->deleteUser($id);
            } else {
                // Message ou action si l'utilisateur n'est pas autorisé a supprimer le compte
                Session::addFlash("error", "Vous n'êtes pas autorisé a supprimer ce compte");
            }

            // Message flash si l'utilisateur est supprimé sinon message erreur
            if($id) {
                Session::addFlash("success", "L'utilisateur a été supprimé");
            } else {
                Session::addFlash("error", "L'utilisateur n'a pas été supprimé");
            }

            // On redirige vers la liste des utilisateurs
            $this->redirectTo("security", "usersList");

        }
        

    }