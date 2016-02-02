<?php
/**
 * Created by PhpStorm.
 * User: moussa
 * Date: 22/01/2016
 * Time: 16:42
 */
require_once 'inc/bootstrap.php';
require 'inc/functions.php';
$auth = App::getAuth();
$auth->restrict();
if(empty($_POST) || $_POST['password']!=$_POST['password_confirm']){
    $_SESSION['flash']['danger'] = "Les deux mots de passe ne sont pas valide !";
}else{
    $user_id = $_SESSION['auth']->id;
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    require_once 'inc/db.php';
    $req = $pdo->prepare('UPDATE users set password = ? WHERE id=?');
    $res = $req->execute([$_POST['password'], $user_id]);
    if($res){
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour!!";
    }else{
        $_SESSION['flash']['danger'] = "Attention votre mot de passe n'a pas encore mis à jour!!";
    }
}
?>
<?php require 'inc/header.php';  ?>
<h1>Bonjour <?= $_SESSION['auth']->username;?></h1>

<form action="" method="post">
    <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Changer le mot de passe">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="password_confirm" placeholder="Confirmer le mot de passe">
    </div>
    <button class="btn btn-primary">Changer mon mot de passe</button>
</form>
<?php require 'inc/footer.php'; ?>

