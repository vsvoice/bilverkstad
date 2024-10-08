<?php

class Project {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertNewProject(int $carId, int $customerId, string $defectDesc, string $workDesc) {

        $stmt_insertNewProject = $this->pdo->prepare('INSERT INTO table_projects (customer_id_fk, car_id_fk, defect_desc, work_desc, status_id_fk)
            VALUES 
            (:customerId, :carId, :defectDesc, :workDesc, 1)');
        $stmt_insertNewProject->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt_insertNewProject->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt_insertNewProject->bindParam(':defectDesc', $defectDesc, PDO::PARAM_STR);
        $stmt_insertNewProject->bindParam(':workDesc', $workDesc, PDO::PARAM_STR);
        $stmt_insertNewProject->execute();

        // Check if query returns any result
        if($stmt_insertNewProject->rowCount() > 0) {
            array_push($this->errorMessages, "Projektet finns redan ");
            $this->errorState = 1;
        }

        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }
    }

    public function selectSingleProject($projectId) {
        // Select data from single project in table_projects
        $projectDataArray = $this->pdo->query("SELECT 
            table_projects.*, 
            table_customers.*, 
            table_cars.*
        FROM 
            table_projects
        JOIN 
            table_customers ON table_projects.customer_id_fk = table_customers.customer_id
        JOIN 
            table_cars ON table_projects.car_id_fk = table_cars.car_id
        WHERE 
            table_projects.project_id = $projectId")->fetchAll();
                return $projectDataArray;
    }

    public function selectProjectProducts($projectId) {
        // Select all products linked to project in table_project_product
        $projectProductsArray = $this->pdo->query("SELECT table_products.*
            FROM table_products
            JOIN table_project_product ON table_products.product_id = table_project_product.product_id_fk
            WHERE table_project_product.project_id_fk = $projectId")->fetchAll();
        return $projectProductsArray;
    }

}

?>