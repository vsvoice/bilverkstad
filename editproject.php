<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Redigera Projekt</h1>
		<h2 class="h4 my-3">Bil</h2>

		<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
			Bläddra bland bilar
		</button>

		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Välj bil</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tillbaka</button>
						<button type="button" class="btn btn-primary">Ny bil</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h3 class="h6">Märke+Modell</h3>
			</div>
			<div class="col">
				<h3 class="h6">Registernummer</h3>
			</div>
		</div>

	<h2 class="h4 my-3">Kund</h2>

	<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
			Bläddra bland kunder
		</button>

		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Välj kund</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tillbaka</button>
						<button type="button" class="btn btn-primary">Ny kund</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<h3 class="h6">Namn</h3>
			</div>
			<div class="col">
				<h3 class="h6">Telefonnummer</h3>
			</div>
			<div class="col">
				<h3 class="h6">Epost</h3>
			</div>
			<div class="col mb-3">
				<h3 class="h6">adress, Postnummer, Ort</h3>
			</div>
		</div>

	<form>	
	<h2 class="h2 mt-3 mb-2">Om projektet</h2>

	<label class="h4 my-3">Felbeskrivning</label>
	<textarea class="form-control"></textarea>
	
	<label class="h4 my-3">Arbetsbeskrivning</label>
	<textarea class="form-control"></textarea>

	<input type="submit" class="btn btn-primary my-3" value="Redigera">
	</form>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>