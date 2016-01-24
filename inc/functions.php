<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 20/01/2016
 * Time: 12:22
 */

function debug($vari){
    echo '<pre>'. print_r($vari, true) . '</pre>';
}
function str_random($length){
    $alphabet = "123456789azertyuiopsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function isLogged(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'êtes pas connecté !!";
        header('Location: login.php');
        exit();
    }
}
function reconnect_from_cookie(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once 'inc/db.php';
        if(!isset($pdo)){
            global $pdo;
        }
        $wasConnected = $_COOKIE['remember'];
        $parts = explode('==', $wasConnected);
        $user_id = $parts[0];
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if($user){
            $expected = $user->id. "==" . $user->remember_token . sha1($user->id, "lesauveur");
            if($expected == $wasConnected) {
                $_SESSION['auth'] = $user;
                setcookie("remember", $wasConnected, time() + 60*60*24*30);
            }else{
                setcookie('remember', null, -1);
            }
        }else{
            setcookie('remember', null, -1);
        }
    }
}