<?php
require_once 'inc/bootstrap.php';

/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 22/01/2016
 * Time: 16:33
 */

$user_id = $_GET['id'];
$token = $_GET['token'];
$db = App::getDataBase();
$auth = App::getAuth();
if($auth->confirm($db, $user_id, $token)){
    Session::getInstance()->setFlash('success', 'Votre compte a été bien crée!');
    App::redirect('account.php');
}else{
    Session::getInstance()->setFlash('danger', 'Ce lien n\'est pas valide!!');
    App::redirect('login.php');
}
