<?php
    class Grade {
        private $user_id;
        private $nilai_tugas;
        private $nilai_uts;
        private $nilai_uas;

        function __construct($id, $tugas, $uts, $uas) {
            $this->user_id = $id;
            $this->nilai_tugas = $tugas;
            $this->nilai_uts = $uts;
            $this->nilai_uas = $uas;
        }

        public function getId() { return $this->user_id; }
        public function getTugas() { return $this->nilai_tugas; }
        public function getUTS() { return $this->nilai_uts; }
        public function getUAS() { return $this->nilai_uas; }
    }
?>
