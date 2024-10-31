<?php
include_once '../includes/config.php';
include_once '../includes/class.user.php';
$user = new User($pdo);

if( isset($_GET["q"])) {
    $search = $_GET["q"];
} else {
    $search = " ";
}

$usersArray = $user->searchUsers($search);

$user->populateUserField($usersArray);
?>