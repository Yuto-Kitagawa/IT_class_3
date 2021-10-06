<?php

include "../classes/functions.php";

$username = htmlspecialchars($_POST['userName'], ENT_QUOTES, 'UTF-8');
$email = $_POST['emailAddress'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$func = new Functions;

//パスワードが同じならハッシュ化して登録手順に進む
if ($password == $password2) {
    $newpassword = password_hash($password, PASSWORD_DEFAULT);
    $func->createUser($username, $email, $newpassword);
    exit;
} else {
    header('Location: ./createUser.php?err=1');
    exit;
}
