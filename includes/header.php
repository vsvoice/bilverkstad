<?php
require_once 'includes/class.user.php';
require_once 'includes/class.car.php';
require_once 'includes/class.customer.php';
require_once 'includes/config.php';
$user = new User($pdo);
$car = new Car($pdo);
$customer = new Customer($pdo);

if(isset($_GET['logout'])) {
	$user->logout();
}

$menuLinks = array(
    array(
        "title" => "Startsida",
        "url" => "home.php"
	),
	array(
        "title" => "Skapa projekt",
        "url" => "newproject.php"
	),
	array(
        "title" => "Kunder",
        "url" => "customers.php"
	),
	array(
        "title" => "Bilar",
        "url" => "cars.php"
	)
);
$adminMenuLinks = array(
    array(
        "title" => "Administratör",
        "url" => "admin.php"
    )
);
?>

<!DOCTYPE html>
<html>
<head>
	<title>OOP & PDO Login System</title>
	<link rel="stylesheet" href="css/style.css">
	<!--<script defer src="js/script.js"></script>-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body>
<header class="container-fluid bg-dark mb-5 px-0">
	<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark px-2 ps-lg-4" data-bs-theme="dark">
	<div class="container-fluid px-2 px-sm-4">
		<a class="navbar-brand" href="home.php">OOP & PDO Login System</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
		<ul class="navbar-nav">
			<?php
			if(isset($_SESSION['user_id'])) {
				foreach ($menuLinks as $menuItem) {
					echo "<li class='nav-item'>
					<a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
					</li>";
				}
			}
			
			if(isset($_SESSION['user_id'])) {
				if ($user->checkUserRole(200)) {
					foreach ($adminMenuLinks as $menuItem) {
						echo "<li class='nav-item'>
						<a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
						</li>";
					}
				}
				echo "
				<li class='nav-item'>
					<a class='nav-link' href='?logout=1.php'>Log Out</a>
				</li>";
			} else {
				echo "
				<li class='nav-item'>
					<a class='nav-link' href='index.php'>Log in</a>
				</li>
				<li class='nav-item'>
					<a class='nav-link' href='newuser.php'>New User</a>
				</li>";
			}
		
			?>
			<!--<li class="nav-item">
			<a class="nav-link" href="home.php">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="admin.php">Admin</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="account.php">Account</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="register.php">Sign Up</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="?logout=1">Log Out</a>
			</li>-->
		</ul>
		</div>
	</div>
	</nav>

</header>