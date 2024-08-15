<?php
include_once 'includes/header.php';


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