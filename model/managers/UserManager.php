<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\UserManager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        // méthode pour trouver un utilisateur en fonction de son email
        public function findOneByEmail($email){

            $sql = "
                SELECT *
                FROM ".$this->tableName." u
                WHERE u.email = :email
                ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["email" => $email], false), 
                $this->className
            );

        }

        // Méthode pour trouver un utilisateur par le pseudo
        public function findOneByPseudo($pseudo){

            $sql = "
                SELECT *
                FROM ".$this->tableName." u
                WHERE u.pseudo = :pseudo
                ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["pseudo" => $pseudo], false),
                $this->className
            );
        }

        // Requête personnalisé pour ban un utilisateur pour une durée determiné
        public function banUser($id, $bannedUntil){

            $sql = "
                UPDATE ".$this->tableName." u
                SET u.bannedUntil = :bannedUntil
                WHERE u.id_user = :id
                ";

            return DAO::update($sql, [
                "id" => $id,
                "bannedUntil" => $bannedUntil
            ]);
        }

        // Requête personnalisé pour débannir un utilisateur
        public function unbanUser($id){

            $sql = "
                UPDATE ".$this->tableName." u
                SET u.bannedUntil = NULL
                WHERE u.id_user = :id
                ";

            return DAO::update($sql, [
                "id" => $id
            ]);
        }

        // Requête personnalisé pour supprimer un utilisateur
        public function deleteUser($id){

            $sql = "
                DELETE FROM ".$this->tableName." u
                WHERE u.id_user = :id
                ";

            return DAO::delete($sql, [
                "id" => $id
            ]);
        }

    }