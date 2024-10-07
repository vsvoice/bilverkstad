<?php

class Car {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertNewCar(string $brand, string $model, string $license) {

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

    public function selectAllCars() {
        $allCarsArray = $this->pdo->query("SELECT * FROM table_cars ORDER BY car_id DESC")->fetchAll();
        return $allCarsArray;
    }

    public function populateCarField($carsArray) {

        echo "<div class='list-group list-group-flush'>";

        foreach ($carsArray as $car) {
			echo "<button type='button' class='list-group-item list-group-item-action px-4' aria-current='true' data-bs-dismiss='modal' value='{$car['car_id']}' onclick='selectProjectCar(this.value)'>
                <div class='row'>
                    <div class='col-5'>{$car['car_brand']} {$car['car_model']}</div>
                    <div class='col-5 text-truncate'>{$car['car_license']}</div>
                </div>
            </button>";
        }

        echo "</div>";
    }

    public function getCarDataById($id) {
        // Prepare and execute the query to fetch user data by ID
        $carData = $this->pdo->query("SELECT * FROM table_cars WHERE car_id = $id")->fetch();
        
        echo "<span id='car-brand'>{$carData['car_brand']}</span> <span id='car-model'>{$carData['car_model']}</span> <span class='ms-4' id='car-license'>{$carData['car_license']}</span>";
    }
}

?>