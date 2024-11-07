<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
	// Prevent accountants from accessing page
    if($user->checkUserRole(50) && !$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

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
		<h1 class="my-5">Ny bil</h1>

		<form action="" method="post">
			<div class="card rounded-4 text-start shadow-sm p-4 mt-2 mb-4">
				<label for="brand" class="form-label">Märke *</label><br>
				<input class="form-control mb-3" type="text" name="brand" id="brand" value="" required="required"><br>

				<label for="model" class="form-label">Modell *</label><br>
				<input class="form-control mb-3" type="text" name="model" id="model" value="" required="required"><br>

				<label for="license" class="form-label">Registernummer *</label><br>
				<input class="form-control mb-3" type="text" name="license" id="license" value="" required="required"><br>
			</div>

			<input type="submit" class="btn btn-primary" name="new-car-submit" value="Skapa ny bil">
			
		</form>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>