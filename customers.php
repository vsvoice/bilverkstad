<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Kunder</h1>

		<a class="btn btn-primary" href="newcustomer.php" role="button">Ny kund</a>

		<div class="row my-3">
			<form>
				<h2 class="h5">Sök Kund</h2>
			<input type="text">
			<!--<input type="submit" class="btn btn-sm btn-primary" value="sök"> -->
			</form>
			<div class="col my-3">
				<h2 class="h4">Namn</h2>
			</div>
			<div class="col my-3">
				<h2 class="h4">Telefon</h2>
			</div>
			<div class="col my-3">
				<h2 class="h4">E-post</h2>
			</div>
			<div class="col my-3">
				<h2 class="h4">Address</h2>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>