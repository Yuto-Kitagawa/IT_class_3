<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['id']);
unset($_SESSION['email']);
header("location: ../" . $_SESSION['URL']);
exit;
