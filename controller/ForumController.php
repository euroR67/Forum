<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategorieManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          

            // On récupère les topics et on les envoie à la vue
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["dateCreation", "DESC"])
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
        
        
        public function listCategorieTopics() {

            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/topicsCategorie.php",
                "data" => [
                    "topics" => $topicManager->categorieTopics(["dateCreation", "DESC"])
                ]
            ];

        }

    }
