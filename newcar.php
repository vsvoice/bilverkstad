<?php
include_once 'includes/header.php';

if (isset($_POST['new-car-submit'])) {
    $feedbackMessages = $car->insertNewCar(
		$user->cleanInput($_POST['brand']), 
		$user->cleanInput($_POST['model']), 
		$user->cleanInput($_POST['license'])
	);

	if($feedbackMessages === 1) {
		echo "<div class='container'>
				<div class='alert alert-success text-center' role='alert'>
					Bilen har skapats.
				</div>
			</div>";
	} else {
		echo "<div class='container'>";
		foreach($feedbackMessages as $message) {
			echo "<div class='alert alert-danger text-center' role='alert'>";
			echo 	$message;
			echo "</div>";
		}
		echo "</div>";
    }
}
?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5"></h1>

		<form action="" method="post">

			<label for="brand" class="form-label">Märke</label><br>
			<input class="form-control" type="text" name="brand" id="brand" value="" required="required"><br>

			<label for="model" class="form-label">Modell</label><br>
			<input class="form-control" type="text" name="model" id="model" value="" required="required"><br>

			<label for="license" class="form-label">Registernummer</label><br>
			<input class="form-control" type="text" name="license" id="license" value="" required="required"><br>


			<input type="submit" class="btn btn-primary" name="new-car-submit" value="Skapa ny bil">
			
		</form>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>