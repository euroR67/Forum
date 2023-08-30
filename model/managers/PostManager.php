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
                    inner join topic t on p.topic_id = t.id_topic
                    inner join categorie c on t.categorie_id = c.id_categorie
                    WHERE p.topic_id = :id";
            // var_dump($sql);
            
                   

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }

    }