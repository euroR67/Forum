<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\PostManager;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        // méthode pour afficher tout les topics appartenant à une catégorie depuis l'id de la catégorie
        public function findPostsByTopic($id) {

            $sql = "SELECT *
                    FROM ".$this->tableName." p 
                    WHERE p.topic_id = :id 
                    ORDER BY p.datePost ASC";
                    

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }

        // méthode pour afficher tout les topics appartenant à une catégorie depuis l'id de la catégorie
        public function findPostsByUser($id) {

            $sql = "SELECT *
                    FROM ".$this->tableName." p 
                    WHERE p.user_id = :id 
                    ORDER BY p.datePost DESC";
                    

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }

        // Méthode pour récupérer l'id du premier post d'un topic
        public function findFirstPostByTopic($id) {

            $sql = "SELECT p.id_post
                    FROM ".$this->tableName." p 
                    WHERE p.topic_id = :id
                    AND p.datePost = 
                    (SELECT MIN(datePost) FROM post WHERE topic_id = :id)";
                    
            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false),
                $this->className
            );

        }

        public function updatePost($id, $texte, $modifiedBy) {
            $sql = "UPDATE ".$this->tableName." p
                    SET texte = :texte,
                        lastModified = NOW(), -- Utilisez la fonction SQL NOW() pour obtenir la date actuelle
                        modifiedBy = :modifiedBy
                    WHERE p.id_post = :id";
        
            return DAO::update($sql, ['id' => $id, 'texte' => $texte, 'modifiedBy' => $modifiedBy]);
        }
        

    }