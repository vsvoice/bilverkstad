<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5"></h1>

		<form action="" method="post">

			<label for="fname" class="form-label">Förnamn</label><br>
			<input class="form-control" type="text" name="fname" id="fname" value="" required="required"><br>

			<label for="lname" class="form-label">Efternamn</label><br>
			<input class="form-control" type="text" name="lname" id="lname" value="" required="required"><br>

			<label for="email" class="form-label">E-postadress</label><br>
			<input class="form-control" type="email" name="email" id="email" value="" required="required"><br>

			<label for="upassnew" class="form-label">Telefonnummer</label><br>
			<input class="form-control" type="text" name="upassnew" id="upassnew" required="required"><br>

			<label for="upassrepeat" class="form-label">Adress</label><br>
			<input class="form-control mb-2" type="text" name="upassrepeat" id="upassrepeat" required="required"><br>


			<input type="submit" class="btn btn-primary" name="new-customer-submit" value="Skapa ny kund">
			
		</form>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>