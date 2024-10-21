<?php

class Project {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Insert a new project (existing method)
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

    public function getProjectById(int $projectId) {
        // Join the correct table names for customers and cars
        $stmt = $this->pdo->prepare('
            SELECT p.*, c.customer_fname, c.customer_lname, c.customer_phone, c.customer_email, c.customer_address, c.customer_zip, c.customer_area,
                   ca.car_brand, ca.car_model, ca.car_license
            FROM table_projects p
            JOIN table_customers c ON p.customer_id_fk = c.customer_id
            JOIN table_cars ca ON p.car_id_fk = ca.car_id
            WHERE p.project_id = :projectId
        ');
    
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch the result as an associative array
    }
    

    // Update project details
    public function updateProject(int $projectId, int $carId, int $customerId, string $defectDesc, string $workDesc) {
        // Use 'project_id' for identifying the project
        $stmt = $this->pdo->prepare('UPDATE table_projects 
            SET car_id_fk = :carId, customer_id_fk = :customerId, defect_desc = :defectDesc, work_desc = :workDesc
            WHERE project_id = :projectId');
        $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':defectDesc', $defectDesc, PDO::PARAM_STR);
        $stmt->bindParam(':workDesc', $workDesc, PDO::PARAM_STR);
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return true;  // Successfully updated
        } else {
            return false; // No rows affected or failed
        }
    }

public function updateProjectStatus(int $projectId, int $statusId) {
    // Update the status_id_fk of the project
    $stmt = $this->pdo->prepare('UPDATE table_projects 
        SET status_id_fk = :statusId
        WHERE project_id = :projectId');
    $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
    $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return true;  // Successfully updated the status
    } else {
        return false; // No rows affected or failed
    }
}
}

?>
