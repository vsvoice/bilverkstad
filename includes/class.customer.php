<?php

class Customer {

    private $pdo;


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



}

?>