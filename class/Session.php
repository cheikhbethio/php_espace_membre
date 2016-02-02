<?php

/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 01/02/2016
 * Time: 22:26
 */
class Session{

    static $instance;
    static function getInstance(){
        if(!self::$instance){
            self::$instance  = new Session();
        }
        return self::$instance;
    }
    public function __construct(){
        session_start();
    }

    public function setFlash($field, $message){
        $_SESSION['flash'][$field] = $message;
    }
    public function hasFlashes(){
        return isset($_SESSION['flash']);
    }
    public function getFlashes(){
        $flashes = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flashes;
    }
    public function write($key, $value){
        $_SESSION[$key] = $value;
    }
    public function read($key){
       return  isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    public function delete($key){
        unset($_SESSION[$key]);
    }
}