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

    public function insertNewProduct(string $prodName, string $prodPrice, string $prodNumber, int $projectId) {

        $prodPrice = str_replace(',', '.', $prodPrice);
        if (!is_numeric($prodPrice)) {
            array_push($this->errorMessages, "Det angivna priset är inte ett giltigt tal ");
            $this->errorState = 1;
        }

        $stmt_insertNewProduct = $this->pdo->prepare('INSERT INTO table_products (name, price, invoice_number)
            VALUES 
            (:prodName, :prodPrice, :prodNumber)');
        $stmt_insertNewProduct->bindParam(':prodName', $prodName, PDO::PARAM_STR);
        $stmt_insertNewProduct->bindParam(':prodPrice', $prodPrice, PDO::PARAM_STR);
        $stmt_insertNewProduct->bindParam(':prodNumber', $prodNumber, PDO::PARAM_STR);
        $stmt_insertNewProduct->execute();

        $lastProductId = $this->pdo->lastInsertId();

        $stmt_insertIntoProjectProduct = $this->pdo->prepare('INSERT INTO table_project_product (project_id_fk, product_id_fk)
            VALUES 
            (:projectId, :productId)');
        $stmt_insertIntoProjectProduct->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt_insertIntoProjectProduct->bindParam(':productId', $lastProductId, PDO::PARAM_STR);
        $stmt_insertIntoProjectProduct->execute();


        // Check if query returns any result
        if($stmt_insertIntoProjectProduct->rowCount() > 0) {
            array_push($this->errorMessages, "Lyckades inte mata in i tabellen table_project_product ");
            $this->errorState = 1;
        }

        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }

    }

    public function selectWorkingHours(string $date, int $userId, int $projectId) {

        // SELECT hours of current user on selected date AS WELL AS user total hours on project from table_hours
        $stmt_selectWorkingHours = $this->pdo->prepare('SELECT *, 
            (SELECT SUM(h_amount) FROM table_hours WHERE u_id_fk = :uid_sub AND p_id_fk = :pid_sub) as total_hours 
            FROM table_hours 
            WHERE u_id_fk = :uid AND h_date = :hdate AND p_id_fk = :pid'
        );
        
        // Bind parameters for the outer query
        $stmt_selectWorkingHours->bindParam(':uid', $userId, PDO::PARAM_INT);
        $stmt_selectWorkingHours->bindParam(':hdate', $date, PDO::PARAM_STR);
        $stmt_selectWorkingHours->bindParam(':pid', $projectId, PDO::PARAM_INT);

        // Bind parameters for the subquery
        $stmt_selectWorkingHours->bindParam(':uid_sub', $userId, PDO::PARAM_INT);
        $stmt_selectWorkingHours->bindParam(':pid_sub', $projectId, PDO::PARAM_INT);
        $stmt_selectWorkingHours->execute();
        
        return $stmt_selectWorkingHours->fetch();
    }

    public function insertWorkingHours(int $projectId, int $userId, int $hours, string $date) {

        if ($this->selectWorkingHours($date, $userId, $projectId) === false) 
        {
            $stmt_insertWorkingHours = $this->pdo->prepare('INSERT INTO table_hours (p_id_fk, u_id_fk, h_amount, h_date)
            VALUES 
            (:pid, :uid, :hamount, :hdate)');
            $stmt_insertWorkingHours->bindParam(':pid', $projectId, PDO::PARAM_INT);
            $stmt_insertWorkingHours->bindParam(':uid', $userId, PDO::PARAM_INT);
            $stmt_insertWorkingHours->bindParam(':hamount', $hours, PDO::PARAM_INT);
            $stmt_insertWorkingHours->bindParam(':hdate', $date, PDO::PARAM_STR);

            if(!$stmt_insertWorkingHours->execute()) {
                array_push($this->errorMessages, "Lyckades inte mata in arbetstiden ");
                $this->errorState = 1;
            }
        }
        else 
        {
            $stmt_editWorkingHours = $this->pdo->prepare('
            UPDATE table_hours
            SET h_amount = :hamount
            WHERE p_id_fk = :pid AND u_id_fk = :uid AND h_date = :hdate');
            $stmt_editWorkingHours->bindParam(':hamount', $hours, PDO::PARAM_INT);
            $stmt_editWorkingHours->bindParam(':pid', $projectId, PDO::PARAM_INT);
            $stmt_editWorkingHours->bindParam(':uid', $userId, PDO::PARAM_INT);
            $stmt_editWorkingHours->bindParam(':hdate', $date, PDO::PARAM_STR);

            if(!$stmt_editWorkingHours->execute()) {
                array_push($this->errorMessages, "Lyckades inte uppdatera arbetstiden ");
                $this->errorState = 1;
            }
    
        }

        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }
    }

}

?>