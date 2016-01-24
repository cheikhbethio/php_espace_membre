<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 20/01/2016
 * Time: 12:50
 */

$pdo = new PDO('mysql:host=localhost;dbname=tuto_php_espacemembre;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);