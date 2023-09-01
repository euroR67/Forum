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
          

            // On récupère les topics et on les envoie à la vue
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateTopic", "DESC"])
                ]
            ];
        
        }

        // Méthode pour récupérer les catégories et les envoyer à la vue
        public function listCategories(){

            $categorieManager = new CategorieManager();

            return [
                "view" => VIEW_DIR."forum/listCategories.php",
                "data" => [
                    "categories" => $categorieManager->findAll(["nomCategorie", "ASC"])
                ]
            ];

        }
        
        // Méthode pour récupérer les topics d'une catégorie et les envoyer à la vue
        public function listTopicsByCategorie($id) {

            $topicManager = new TopicManager();
            $categorieManager = new CategorieManager();

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

            $postManager = new PostManager();
            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/PostsByTopics.php",
                "data" => [
                    // On appelle la méthode findPostsByTopic() du PostManager pour récupérer les posts d'un topic
                    "posts" => $postManager->findPostsByTopic($id, ["datePost", "ASC"]),
                    // On appelle la méthode findOneById() du TopicManager pour récupérer les posts d'un topic
                    "topic" => $topicManager->findOneById($id)
                ]
            ];

        }

        // Méthode pour ajouter un post
        public function addPost($id){
          
            $postManager = new PostManager();
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS);
           
           
            $data = [
                'texte'=> $text ,
                'user_id'=> 10,
                'topic_id'=> $id
            ];

            $postManager->add($data);

            // On redirige vers la page du topic
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }

        // Méthode pour suppimer un post sauf si c'est le premier post du topic avec findFirstPostByTopic()
        public function deletePost($id){

            // On instancie les managers
            $postManager = new PostManager();

            // On récupère l'id du topic du post
            $post = $postManager->findOneById($id);
            $idTopic = $post->getTopic()->getId();
            
            // On récupère l'id du premier post du topic
            $firstPost = $postManager->findFirstPostByTopic($idTopic);
           
            $idFirstPost = $firstPost->getId();
            // Si l'id du post est différent de l'id du premier post du topic, on supprime le post
            if($id != $idFirstPost){
                $postManager->delete($id);
            }

            // On redirige vers la page du topic
            $this->redirectTo("forum", "listPostsByTopic", $idTopic);

        }

        // Méthode pour supprimer un sujet et tous les posts associés
        public function deleteTopic($id){

            // On instancie les managers
            $topicManager = new TopicManager();

            // On récupère l'id du topic
            $topic = $topicManager->findOneById($id);
            $idTopic = $topic->getId();

            // On supprime le sujet et tous les posts associés
            $topicManager->delete($idTopic);

            // On redirige vers la liste des topics de la catégorie du sujet supprimé
            $this->redirectTo("forum", "listTopicsByCategorie", $topic->getCategorie()->getId());
            

        }

        // Méthode pour ajouter un sujet et un premier post
        public function ajoutSujet($id){

            // On instancie les managers
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            
            // On récupère les données du formulaire et on les filtre pour éviter les injections
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS);
            
            // On ajoute le sujet et on récupère l'id du sujet
            $newTopicId = $topicManager->add([
                "titre" => $titre,
                "user_id" => 10,
                "categorie_id" => $id]);

            // On ajoute le premier post dans le sujet avec l'id du sujet récupéré
            $postManager->add([
                "texte" => $text,
                "user_id" => 10,
                "topic_id" => $newTopicId]);
            
            // On redirige vers la page du sujet créé via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $newTopicId);
        }

        // Méthode pour modifier le titre d'un sujet
        public function modifierSujet(){

            // On instancie les managers
            $topicManager = new TopicManager();

            // On récupère le nouveau titre du sujet
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);

            // On modifie le titre du sujet
            $topicManager->update([
                "id_topic" => $id,
                "titre" => $titre]);

            // On redirige vers la page du sujet modifié via l'id du sujet
            $this->redirectTo("forum", "listPostsByTopic", $id);

        }

    }