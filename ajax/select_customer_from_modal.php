<?php 
//Security risk with alax folder accessible via browser?
include_once '../includes/config.php';

$input = $_GET["id"];

$stmt_selectCustomer = $pdo->prepare('SELECT * FROM table_customers WHERE customer_id=:input');
$stmt_selectCustomer->bindParam(':input', $input, PDO::PARAM_STR);
$stmt_selectCustomer->execute();

foreach($stmt_selectCustomer as $row) {
    echo $row['customer_fname'] . ' ' . $row['customer_lname'] . '<span class="ms-4">' . $row['customer_phone'] . '</span> <span class="ms-4">' . $row['customer_email'] . '</span>	<span class="ms-4">' . $row['customer_address'] . ' ' . $row['customer_zip'] . ' ' . $row['customer_area'] . '</span>';

}

?>