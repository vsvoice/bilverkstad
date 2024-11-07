<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
	// Prevent accountants from accessing page
    if($user->checkUserRole(50) && !$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

if (isset($_POST['new-customer-submit'])) {
    $feedbackMessages = $customer->insertNewCustomer(
		$user->cleanInput($_POST['fname']), 
		$user->cleanInput($_POST['lname']), 
		$user->cleanInput($_POST['phone']), 
		$user->cleanInput($_POST['email']), 
		$user->cleanInput($_POST['address']), 
		$user->cleanInput($_POST['zip']), 
		$user->cleanInput($_POST['area'])
	);
	
	if($feedbackMessages === 1) {
		echo "<div class='container'>
				<div class='alert alert-success text-center' role='alert'>
					Kunden har skapats.
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
		<h1 class="my-5">Ny kund</h1>

		
		<form action="" method="post">
			<div class="card rounded-4 text-start shadow-sm p-4 mt-2 mb-4">
				<label for="fname" class="form-label">Förnamn *</label><br>
				<input class="form-control mb-3" type="text" name="fname" id="fname" value="" required="required"><br>

				<label for="lname" class="form-label">Efternamn *</label><br>
				<input class="form-control mb-3" type="text" name="lname" id="lname" value="" required="required"><br>

				<label for="email" class="form-label">E-postadress</label><br>
				<input class="form-control mb-3" type="email" name="email" id="email" value=""><br>

				<label for="phone" class="form-label">Telefonnummer</label><br>
				<input class="form-control mb-3" type="text" name="phone" id="phone"><br>

				<label for="address" class="form-label">Adress</label><br>
				<input class="form-control mb-3" type="text" name="address" id="address"><br>

				<label for="zip" class="form-label">Postnummer</label><br>
				<input class="form-control mb-3" type="text" name="zip" id="zip"><br>

				<label for="area" class="form-label">Postanstalt</label><br>
				<input class="form-control mb-3" type="text" name="area" id="area"><br>
			</div>
			<input type="submit" class="btn btn-primary" name="new-customer-submit" value="Skapa ny kund">
			
		</form>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>