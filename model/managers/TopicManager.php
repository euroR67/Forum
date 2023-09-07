<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }

        // méthode pour afficher tout les topics appartenant à une catégorie depuis l'id de la catégorie
        public function findTopicsByCategorie($id) {

            $sql = "SELECT t.*, 
                    (SELECT COUNT(*) FROM post p WHERE p.topic_id = t.id_topic) AS nbPosts,
                    (SELECT MAX(p.datePost) FROM post p WHERE p.topic_id = t.id_topic) AS lastPostDate
                    FROM topic t
                    WHERE t.categorie_id = :id
                    ORDER BY lastPostDate DESC";

                   
            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );

        }

        // méthode pour modifier le titre d'un topic
        public function updateTopic($id, $titre) {

            $sql = "UPDATE ".$this->tableName." t
                    SET titre = :titre
                    WHERE t.id_topic = :id";

            return DAO::update($sql, ["id" => $id, "titre" => $titre]);
        }

        // Méthode pour verrouiller un topic
        public function lockTopic() {

            $sql = "UPDATE ".$this->tableName." t
                    SET titre = :titre
                    WHERE t.id_topic = :id";

            return DAO::update($sql, ["id" => $id, "titre" => $titre]);

        }

    }