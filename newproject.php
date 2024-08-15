<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5"></h1>

		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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



	</div>
</div>

<?php
include_once 'includes/footer.php';
?>