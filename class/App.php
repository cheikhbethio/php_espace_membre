<?php

/* Date: 01/02/2016 */
class App{
    static $db =null;

    static function getDataBase(){
        if(!self::$db){
            self::$db = new Database('root', '', 'tuto_php_espacemembre');
        }
        return self::$db;
    }
    static function redirect($page){
        header("Location: $page");
        exit();
    }
    static function getAuth(){
        return new Auth(Session::getInstance());
    }
}