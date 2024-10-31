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
    <div class="mw-500 mx-auto">

        <h1 class="my-5">Administratör</h1>

        <a class="btn btn-primary mb-2" href="newuser.php">Skapa ny användare</a>

        <div class="mt-3">
            <label for="search" class="form-label">Sök användare (användarnamn eller e-post)</label><br>
            <input class="form-control" type="text" name="search" id="search" onkeyup="searchUsers(this.value)"><br>
        </div>

        <table class='table table-striped'>
            <thead>
                <tr>
                <th scope='col'>Användarnamn</th>
                <th scope='col'>E-post</th>
                <th scope='col'></th>
                </tr>
            </thead>
            <tbody id="user-field">
            </tbody>
        </table>
        
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Code to run when the DOM is ready
        searchUsers(" ");
    });

    function searchUsers(str) {
    if (str.length == 0) {
        str = " ";
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("user-field").innerHTML = this.responseText;
    }
    };
    xmlhttp.open("GET", "ajax/search_users.php?q=" + str, true);
    xmlhttp.send();
    }
</script>

<?php
include_once 'includes/footer.php';
?>