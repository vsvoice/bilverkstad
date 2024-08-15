<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Projekt</h1>
		<a class="btn btn-primary">Redigera</a>
		<h2 class="h4 my-3">Bil</h2>
		<div class="row">
			<div class="col">
				<h3 class="h6">Märke+Modell</h3>
			</div>
			<div class="col">
				<h3 class="h6">Registernummer</h3>
			</div>
		</div>
	<h2 class="h4 my-3">Kund</h2>
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

	<h2 class="h2 mt-3 mb-2">Om projektet</h2>

	<h3 class="h4 my-3">Status</h3>
	<select class="form-select" aria-label="">
		<option value="1">I kö</option>
		<option value="2">Pågående</option>
		<option value="3">Pausad</option>
		<option value="3">Avbokad</option>
		<option value="3">Klar för fakturering</option>
	</select>

	<h3 class="h4 my-3">Felbeskrivning</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius odio eget erat tincidunt, ut ullamcorper massa vestibulum. Vestibulum ex libero, luctus nec posuere vel, luctus vitae turpis. Etiam a turpis arcu. Maecenas et tellus nec massa imperdiet vulputate. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris quis tellus vitae massa suscipit volutpat a nec ipsum. Vestibulum ut pharetra neque, at tristique elit. Phasellus eleifend malesuada nulla, ac volutpat quam egestas sed. Pellentesque ac volutpat eros, vel pharetra velit.</p>
	<h3 class="h4 my-3">Arbetsbeskrivning</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum varius odio eget erat tincidunt, ut ullamcorper massa vestibulum. Vestibulum ex libero, luctus nec posuere vel, luctus vitae turpis. Etiam a turpis arcu. Maecenas et tellus nec massa imperdiet vulputate. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris quis tellus vitae massa suscipit volutpat a nec ipsum. Vestibulum ut pharetra neque, at tristique elit. Phasellus eleifend malesuada nulla, ac volutpat quam egestas sed. Pellentesque ac volutpat eros, vel pharetra velit.</p>

	<div class="row">
		<h3 class="h4 my-3">Produkter</h3>
			<div class="col">
				<ul class="list-group">
					<li class="list-group-item">An item</li>
					<li class="list-group-item">A second item</li>
					<li class="list-group-item">A third item</li>
					<li class="list-group-item">A fourth item</li>
					<li class="list-group-item">And a fifth one</li>
				</ul>
				<a class="btn btn-success my-2">Lägg till</a>
			</div>
	</div>

	<div class="row">
		<div class="col">
			<p class="h4 my-3">Timmar:<span class="ms-4 fw-normal">34h 30min</span></p>
		</div>
		<div class="col text-center">
			<a class="btn btn-success my-2">Lägg till</a>
		</div>
	</div>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>