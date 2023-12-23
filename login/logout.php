<?php
session_start();

session_destroy();
setcookie('username', '', time() - 3600);
setcookie('session_key', '', time() - 3600);

header('Location: /login/login_view.php');
exit;
