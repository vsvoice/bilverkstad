<?php

class Customer {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertNewCustomer(string $fname, string $lname, string $phone, string $email, string $address, string $zip, string $area) {

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

    public function selectAllCustomers() {
        $allCustomersArray = $this->pdo->query("SELECT * FROM table_customers ORDER BY customer_id DESC")->fetchAll();
        return $allCustomersArray;
    }

    public function populateCustomerField($customersArray) {

        echo "<div class='list-group list-group-flush'>";

        foreach ($customersArray as $customer) {
			echo "<button type='button' class='list-group-item list-group-item-action px-4' aria-current='true' data-bs-dismiss='modal' value='{$customer['customer_id']}' onclick='selectProjectCustomer(this.value)'>
                <div class='row'>
                    <div class='col-3'>{$customer['customer_fname']} {$customer['customer_lname']}</div>
                    <div class='col-3 text-truncate'>{$customer['customer_email']}</div>
                    <div class='col-3 text-truncate'>{$customer['customer_phone']}</div>
                    <div class='col-3'>{$customer['customer_address']}</div>
                </div>
            </button>";
        }

        echo "</div>";
    }

}

?>