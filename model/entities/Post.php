<?php
    namespace Model\Entities;

    use App\Entity;

    final class Post extends Entity {

        private $id;
        private $texte;
        private $user;
        private $dateCreation;

        public function __construct($data) {
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

        // Get the value of texte
        public function getTexte() {
                return $this->texte;
        }

        // Set the value of texte
        public function setTexte($texte) {
                $this->texte = $texte;
                return $this;
        }

        // Get the value of user
        public function getUser() {
                return $this->user;
        }

        // Set the value of user
        public function setUser($user) {
                $this->user = $user;
                return $this;
        }

        // Get the value of dateCreation
        public function getDateCreation(){
            $formattedDate = $this->dateCreation->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        // Set the value of dateCreation
        public function setDateCreation($date){
            $this->dateCreation = new \DateTime($date);
            return $this;
        }
    }