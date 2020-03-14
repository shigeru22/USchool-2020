<?php
    class User {
        private $user_id;
        private $first_name;
        private $last_name;
        private $role_id;
        private $address;

        function __construct($id, $fname, $lname, $role, $address) {
            $this->user_id = $id;
            $this->first_name = $fname;
            $this->last_name = $lname;
            $this->role_id = $role;
            $this->address = $address;
        }

        public function getId() { return $this->user_id; }
        public function getFName() { return $this->first_name; }
        public function getLName() { return $this->last_name; }
        public function getRoleId() { return $this->role_id; }
        public function getAddress() { return $this->address; }
    }
?>
