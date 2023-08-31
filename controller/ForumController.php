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
            $text = $_POST['text'];
           
           
            $data = [
                'texte'=> $text ,
                'user_id'=> 1,
                'topic_id'=> $id
            ];

            $postManager->add($data);
            header('Location: index.php?ctrl=forum&action=listPostsByTopic&id='.$id);

        }

        // Méthode pour suppimer un post
        public function deletePost($id){
            $postManager = new PostManager();
            $post = $postManager->findOneById($id);
            $idTopic = $post->getTopic()->getId();

            $postManager->delete($id);
            header('Location: index.php?ctrl=forum&action=listPostsByTopic&id='.$idTopic);

        }

    }