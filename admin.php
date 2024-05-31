<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}


if (isset($_POST['search-users-submit']) && !empty($_POST['search'])) {
    $usersArray = $user->searchUsers($_POST['search']);
}
?>

<div class="container">

<h1>Find Users</h1>

<form action="" method="post">
    <label for="search">Enter Username or Email</label><br>
    <input class="mb-2" type="text" name="search" id="search" required="required"><br>

    <input type="submit" name="search-users-submit" value="Search">
</form>

    <?php
    if(isset($usersArray) && !empty($usersArray)) {
        echo "
        <table class='table table-striped'>
            <thead>
                <tr>
                <th scope='col'>Username</th>
                <th scope='col'>Email</th>
                <th scope='col'></th>
                </tr>
            </thead>
            <tbody>";
        foreach ($usersArray as $user) {
            echo "
            <tr>
                <td>{$user['u_name']}</td>
                <td>{$user['u_email']}</td>
                <td><a class='btn btn-primary' href='admin-account.php?uid={$user['u_id']}'>Edit User</a><br></td>
            </tr>";
        }
        echo "  
            </tbody>
        </table>";
    }
    ?>

</div>

<?php
include_once 'includes/footer.php';
?>