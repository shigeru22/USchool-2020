<?php
    class Role {
        private $role_id;
        private $role_name;
        private $role_desc;

        function __construct($id, $name, $desc) {
            $this->role_id = $id;
            $this->role_name = $name;
            $this->role_desc = $desc;
        }

        public function getId() { return $this->role_id; }
        public function getName() { return $this->role_name; }
        public function getDesc() { return $this->role_desc; }
    }
?>
