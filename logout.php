<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 22/01/2016
 * Time: 19:31
 */

session_start();
setcookie('remember',NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "
    Vous avez bien été déconnecté au revoir et à bientôt
";
header('Location: login.php');

