<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 22/01/2016
 * Time: 19:31
 */

require 'inc/bootstrap.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success', "Vous avez bien été déconnecté au revoir et à bientôt");
App::redirect('login.php');
