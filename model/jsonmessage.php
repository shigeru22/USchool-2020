<?php
    class Message {
        public $message;
        public $description;
        public $token;

        function __construct($msg, $desc, $token) {
            $this->message = $msg;
            $this->description = $desc;
            $this->token = $token;
        }
    }
?>
