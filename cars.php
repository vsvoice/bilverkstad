<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Bilar</h1>

		<a class="btn btn-primary" href="newcar.php" role="button">Ny bil</a>

		<div class="row my-3">
			<form action="" method="post">
				<label for="search" class="form-label" class="h5">Sök Bil</label>
			<input class="form-control" type="text" name="search" id="search">
			<!--<input type="submit" class="btn btn-sm btn-primary" value="sök"> -->
			</form>
			<div class="col my-3">
				<h2 class="h4">Märke</h2>
			</div>
			<div class="col my-3">
				<h2 class="h4">Model</h2>
			</div>
			<div class="col my-3">
				<h2 class="h4">Reg-Nmr</h2>
			</div>
		</div>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>