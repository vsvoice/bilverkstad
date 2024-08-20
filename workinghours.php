<?php
include_once 'includes/header.php';


?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Arbets timmar</h1>

			<div class="container">
				<form>
				<div class="row">
					<div class="col">
						<label for="start-date">Start Datum:</label>
						<input type="date" id="start-date" name="start-date">
					</div>
					<div class="col">
						<label for="end-date">Slut Datum:</label>
						<input type="date" id="end-date" name="end-date">
					</div>
				</div>
				</form>
			</div>

			<div class="container">
				<div class="row">
					<div class="col">
						<h2 class="h5 my-3">Namn</h4>
					</div>
					<div class="col">
						<h2 class="h5 my-3">Arbetstid (h)</h4>
					</div>
				</div>
			</div>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>