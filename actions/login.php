<?php
include "../classes/functions.php";
$email = $_POST['mail'];
$password = $_POST['password'];


$func = new Functions;

$func->Login($email, $password);
exit;
