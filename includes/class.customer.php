<?php

class Customer {

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

    public function insertNewCustomer($fname, $lname, $phone, $email, $address, $zip, $area) {
        $fname = $this->cleanInput($fname);
        $lname = $this->cleanInput($lname);
        $phone = $this->cleanInput($phone);
        $email = $this->cleanInput($email);
        $address = $this->cleanInput($address);
        $zip = $this->cleanInput($zip);
        $area = $this->cleanInput($area);

        $stmt_insertNewCustomer = $this->pdo->prepare('INSERT INTO table_customers (customer_fname, customer_lname, customer_phone, customer_email, customer_address, customer_zip, customer_area)
            VALUES 
            (:fname, :lname, :phone, :email, :address, :zip, :area)');
            $stmt_insertNewCustomer->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':zip', $zip, PDO::PARAM_STR);
            $stmt_insertNewCustomer->bindParam(':area', $area, PDO::PARAM_STR);
            $stmt_insertNewCustomer->execute();

            // Check if query returns any result
            if($stmt_insertNewCustomer->rowCount() > 0) {
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