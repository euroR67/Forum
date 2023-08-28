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
                FROM ".$this->tableName." a
                WHERE a.email = :email
                ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["email" => $email], false), 
                $this->className
            );

        }

    }