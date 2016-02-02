<?php

/* User: moussa
 * Date: 01/02/2016
 */
class Str{
    static  function random($length){
        $alphabet = "123456789azertyuiopsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

}