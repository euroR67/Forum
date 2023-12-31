<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $pseudo;
        private $password;
        private $email;
        private $dateInscription;
        private $role;
        private $bannedUntil;

        public function __construct($data){         
            $this->hydrate($data);        
        }

        // Get the value of id
        public function getId() {
                return $this->id;
        }

        // Set the value of id
        public function setId($id) {
                $this->id = $id;
                return $this;
        }

        // Get the formatted value of bannedUntil
        public function getBannedUntil() {
                if ($this->bannedUntil !== null) {
                return date('d/m/Y', strtotime($this->bannedUntil));
                }
                return null;
        }
    

        // Set the value of bannedUntil
        public function setBannedUntil($bannedUntil) {
                $this->bannedUntil = $bannedUntil;
                return $this;
        }

        // Get the value of pseudo
        public function getPseudo() {
                return $this->pseudo;
        }

        // Set the value of pseudo
        public function setPseudo($pseudo) {
                $this->pseudo = $pseudo;
                return $this;
        }

        // Get the value of password
        public function getPassword() {
                return $this->password;
        }

        // Set the value of password
        public function setPassword($password) {
                $this->password = $password;
                return $this;
        }

        // Get the value of email
        public function getEmail() {
                return $this->email;
        }

        // Set the value of email
        public function setEmail($email) {
                $this->email = $email;
                return $this;
        }

        // Get the value of dateInscription
        public function getDateInscription(){
            $formattedDate = $this->dateInscription->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        // Set the value of dateInscription
        public function setDateInscription($date){
            $this->dateInscription = new \DateTime($date);
            return $this;
        }

        // Get the value of role
        public function getRole() {
                return $this->role;
        }

        // Set the value of role
        public function setRole($role) {
                $this->role = $role;
                return $this;
        }

        // Fonction qui pour vérifier le role d'un utilisateur
        public function hasRole($role) {
                if( $this->role == $role){
                        return true;
                } else {
                        return false;
                };
        }

        public function __toString(){
            return $this->pseudo;
        }

    }