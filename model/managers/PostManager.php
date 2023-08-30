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
        public function findPostsByTopic($id, $order = null) {

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." p 
                    INNER JOIN topic t on p.topic_id = t.id_topic
                    INNER JOIN categorie c on t.categorie_id = c.id_categorie
                    WHERE p.topic_id = :id "
                    . $orderQuery;
                    

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }

    }