<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 22/01/2016
 * Time: 16:33
 */

$user_id = $_GET['id'];
$token = $_GET['token'];
require "inc/db.php";
$req = $pdo->prepare('select * from users WHERE id=?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if($user && $user->confirmation_token == $token){
    $pdo->prepare('update users set confirmation_token =NULL,
          confirm_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = "Votre compte a été bien crée!";
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce lien n'est pas valide!!";
    header('Location: login.php');
}
