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

        // méthode pour trouver tout les posts d'un topic
        public function findPostsByTopic($id){

            $sql = "
                SELECT *
                FROM ".$this->tableName." p
                WHERE p.id_topic = :id
                ";

            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]), 
                $this->className
            );

        }

    }