<?php

include "../classes/functions.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_second = $_POST['password2'];

$func = new Functions;

if ($password == $password_second) {
    $newpassword = password_hash($password, PASSWORD_DEFAULT);
    $func->createUser($username, $email, $newpassword);
} else {
    header('Location: ../contact.html?err=1');
    exit;
}
