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

    }