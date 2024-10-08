<?php 
//Security risk with alax folder accessible via browser?
include_once '../includes/config.php';

$input = $_GET["id"];

$stmt_selectCar = $pdo->prepare('SELECT * FROM table_cars WHERE car_id=:input');
$stmt_selectCar->bindParam(':input', $input, PDO::PARAM_STR);
$stmt_selectCar->execute();

foreach($stmt_selectCar as $row) {
    echo '<span id="car-brand">' . $row['car_brand'] . '</span> <span id="car-model">' . $row['car_model'] . '</span> <span class="ms-4" id="car-license">' . $row['car_license'] . '</span>';

}

?>