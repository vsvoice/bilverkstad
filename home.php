<?php
include_once 'includes/functions.php';	
include_once 'includes/header.php';

$user->checkLoginStatus();

$test = $user->checkUserRole(10);


?>

<div class="container text-center">

    <div class="row my-3">
        <h2>Pågående</h2>
            <div class="col">
            </div>  
    </div>
    <div class="row my-3">
        <h2>I kö</h2>
            <div class="col">
            </div>
    </div>
</div>

<div class="container d-none">

    <div class="row my-3">
        <h2>Klar för Fakturering</h2>
            <div class="col">
            </div>  
    </div>
    <div class="row my-3">
        <h2>Fakturerad</h2>
            <div class="col">
            </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>