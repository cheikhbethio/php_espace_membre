<?php

/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 01/02/2016
 * Time: 14:26
 */
class Validator{
    private $data;
    private $errors=[];

    public function __construct($data){
        $this->data = $data;
    }

    public function getField($field){
        if(!isset($this->data[$field])){
            return null;
        }
        return $this->data[$field];
    }
    public function isAlpha($field, $string)    {
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
            $this->errors[$field] = $string;
        }
    }

    public function isUniq($field, $db, $table, $message){
        $req = $db->query("SELECT * FROM $table WHERE $field = ?", [$this->getField($field)]);
        $user = $req->fetch();
        if($user){
            $this->errors[$field] = $message;
        }
    }
    public function isEmail($field, $message){
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = $message;
        }
    }

    public function isConfirmPWD($field, $message=[]){
        $pass = $this->getField($field);
        if(empty($pass) ||  $pass !=  $this->getField($field.'_confirm')){
            $this->errors[$field] = $message;
        }
    }

    public function isValid(){
        return empty($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }
}