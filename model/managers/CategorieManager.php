<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    // use Model\Managers\CategorieManager;

    class CategorieManager extends Manager{

        protected $className = "Model\Entities\Categorie";
        protected $tableName = "categorie";


        public function __construct(){
            parent::connect();
        }

        // Fonction pour modifier le nom d'une catégorie
        public function updateCategorie($id, $nomCategorie) {

            $sql = "UPDATE ".$this->tableName." c
                    SET nomCategorie = :nomCategorie
                    WHERE c.id_categorie = :id";

            return DAO::update($sql, ["id" => $id, "nomCategorie" => $nomCategorie]);
        }

        // Fonction pour supprimer une catégorie 
        public function deleteCategorie($id) {

            $sql = "DELETE FROM ".$this->tableName." c
                    WHERE c.id_categorie = :id";

            return DAO::delete($sql, ["id" => $id]);
        }


    }