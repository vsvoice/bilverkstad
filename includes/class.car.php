<?php

class Car {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function insertNewCar($brand, $model, $license) {
        $brand = $this->cleanInput($brand);
        $model = $this->cleanInput($model);
        $license = $this->cleanInput($license);

        $stmt_insertNewCar = $this->pdo->prepare('INSERT INTO table_cars (car_brand, car_model, car_license)
            VALUES 
            (:brand, :model, :license)');
            $stmt_insertNewCar->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt_insertNewCar->bindParam(':model', $model, PDO::PARAM_STR);
            $stmt_insertNewCar->bindParam(':license', $license, PDO::PARAM_STR);
            $stmt_insertNewCar->execute();

            // Check if query returns any result
            if($stmt_insertNewCar->rowCount() > 0) {
                array_push($this->errorMessages, "Användaren finns redan ");
                $this->errorState = 1;
            }

            if ($this->errorState == 1) {
                return $this->errorMessages;
            } else {
                return 1;    
            }
    }

}

?>