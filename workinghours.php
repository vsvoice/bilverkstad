<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

$currentDate = date("Y-m-d");
$date30DaysAgo = date("Y-m-d", strtotime("-30 days"));

$totalWorkingHours = $user->getAllWorkingHours($date30DaysAgo, $currentDate);
//var_dump($totalWorkingHours);

?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Arbetstimmar</h1>

			<div class="container">
				<form>
					<div class="row">
						<div class="col">
							<label for="from-date" class="form-label">Från:</label>
							<input type="date" id="from-date" name="from-date" class="form-control" value="<?php echo $date30DaysAgo ?>">
						</div>
						<div class="col">
							<label for="to-date" class="form-label">Till:</label>
							<input type="date" id="to-date" name="to-date" class="form-control" value="<?php echo $currentDate ?>">
						</div>
					</div>
				</form>
			</div>

			<div class="container mt-5">
				<div id="working-hours-headings" class="row border-bottom">
					<div class="col">
						<h2 class="h5 my-3">Namn</h2>
					</div>
					<div class="col">
						<h2 class="h5 my-3">Arbetstid (h)</h2>
					</div>
				</div>

				<ul id="working-hours" class="list-group list-group-flush">
					<?php $user->populateWorkingHoursField($totalWorkingHours); ?>
				</ul>
				
			</div>

	</div>
</div>

<script>
	const fromDate = document.getElementById("from-date");
	const toDate = document.getElementById("to-date");

	fromDate.addEventListener("change", function() {
		getWorkingHours(fromDate.value, toDate.value);
	});
	toDate.addEventListener("change", function() {
		getWorkingHours(fromDate.value, toDate.value);
	});

	function getWorkingHours(fDate, tDate) {
		if (fDate == undefined || fDate == null || fDate == "" || tDate == undefined || tDate == null || tDate == "") {
        	return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("working-hours").innerHTML = this.responseText;
				}
        	};
        xmlhttp.open("GET", "ajax/select_working_hours.php?from=" + fDate + "&to=" + tDate, true);
        xmlhttp.send();
    	}
	}
</script>

<?php
include_once 'includes/footer.php';
?>