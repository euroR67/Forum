<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $titre;
        private $user;
        private $dateCreation;
        private $closed;
        private $categorie;



        public function __construct($data){         
            $this->hydrate($data);        
        }


        // Get the value of categorie
        public function getCategorie() {
                return $this->categorie;
        }

        // Set the value of categorie
        public function setCategorie($categorie) {
                $this->categorie = $categorie;
                return $this;
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

        // Get the value of titre 
        public function getTitre() {
                return $this->titre;
        }

        // Set the value of titre 
        public function setTitre($titre) {
                $this->titre = $titre;
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

        public function getDateCreation(){
            $formattedDate = $this->dateCreation->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setDateCreation($date){
            $this->dateCreation = new \DateTime($date);
            return $this;
        }

        // Get the value of closed
        public function getClosed() {
                return $this->closed;
        }

        // Set the value of closed
        public function setClosed($closed){
                $this->closed = $closed;
                return $this;
        }
    }
?>