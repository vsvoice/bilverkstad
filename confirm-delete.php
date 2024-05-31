<?php
include_once 'includes/header.php';

$userInfoArray = $user->getUserInfo($_GET['uid']);

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

if (isset($_POST['delete-user-submit'])) {
    $deleteFeedback = $user->deleteUser($_GET['uid']);
}
?>

<div class="container justify-content-center text-center">

<?php
if (!isset($deleteFeedback)) {
    echo "<h2 class='mb-5'>Are you sure you want to delete user <span class='fw-bold'>{$userInfoArray['u_name']}</span>?</h2>";

    echo "
    <div class='row flex-column justify-content-center'>
        <div class='col-4 mb-3 mx-auto'>
            <a class='btn btn-warning w-100' href='admin-account.php?uid={$_GET['uid']}'>No, get me out of here!</a>
        </div>
        <div class='col-4 mx-auto'>
            <form action='' method='post'>
                <input type='submit' name='delete-user-submit' value='Delete this user' class='btn btn-danger w-100'>
            </form>
        </div>
    </div>";
} else {
    echo "<h2 class='mb-5'>{$deleteFeedback}</h2>"; 

    echo " 
    <div class='row flex-column justify-content-center'>
        <div class='col-4 mb-3 mx-auto'>
            <a class='btn btn-secondary w-100' href='admin.php'>Return to Admin Page</a>
        </div>
    </div>";
}
?>
    

</div>

<?php
include_once 'includes/footer.php';
?>