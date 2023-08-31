<?php
    namespace Model\Entities;

    use App\Entity;

    final class Post extends Entity {

        private $id;
        private $texte;
        private $user;
        private $datePost;
        private $topic;

        public function __construct($data) {
            $this->hydrate($data);
        }

        // Get the value of id
        public function getId() {
                return $this->id;
        }

        // Get the value of topic
        public function getTopic() {
                return $this->topic;
        }

        // Set the value of topic
        public function setTopic($topic) {
                $this->topic = $topic;
                return $this;
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
        // public function getDateCreation(){
        public function getDatePost(){
            $formattedDate = $this->datePost->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        // Set the value of dateCreation
        // public function setDateCreation($date){
        public function setDatePost($date){
            $this->datePost = new \DateTime($date);
            return $this;
        }

        public function __toString(){
            return $this->texte;
        }

    }