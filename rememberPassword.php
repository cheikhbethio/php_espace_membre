<?php
session_start();
if(!empty($_POST) && !empty($_POST['email'])){
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare("
      SELECT * FROM users
        WHERE email = ? AND confirm_at IS NOT NULL
      ");
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
//    debug($user);
    if($user){
        $token = str_random(70);
        $req = $pdo->prepare("UPDATE  users set reset_token =  ?, reset_at = NOW() WHERE id = ? ");
        $res = $req->execute([$token, $user->id]);
        mail($_POST['email'], 'Initialisation de votre compte', "Pour valider votre compte cliquez sur ce lien :
        http://localhost/tuto/php_espace_membre/reset.php?id={$user->id}&token=$token");
        $_SESSION['flash']['success'] = "un email de réinitialisation vous a été envoyé!";
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] =  "Mot de pass ou identifiant incorrect!";
    }
}
?>
<?php require 'inc/header.php';  ?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>

</form>
<?php require 'inc/footer.php'; ?>
