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
        public function categorieTopics() {
            
        }

    }