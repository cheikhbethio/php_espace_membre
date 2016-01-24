<?php
require 'inc/functions.php';
reconnect_from_cookie();
if(isset($_SESSION['auth'])){
    header('Location: account.php');
    exit();
}

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare("
      SELECT * FROM users
        WHERE (username = :username OR email = :username) AND confirm_at IS NOT NULL
      ");
    $req->execute(['username' =>$_POST['username']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] =  "Vous êtes maintenant bien connecté !";
        if($_POST['remember']){
            $rememberToken = str_random(250);
            $reqUpTok = $pdo->prepare('UPDATE users SET remember_token=? WHERE id=?');
            $reqUpTok->execute([$rememberToken, $user->id]);
            setcookie("remember", $user->id . "==" . $rememberToken . sha1($user->id, "lesauveur"), time() + 60*60*24*30);
        }
       // die();
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] =  "Mot de pass ou identifiant incorrect!";
    }
}
?>
<?php require 'inc/header.php';  ?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo ou Email</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
    </div>
    <button type="submit" class="btn btn-primary">M'INSCRIRE</button>
    <a href="rememberPassword.php">Mot de passe oublié</a>

</form>
<?php require 'inc/footer.php'; ?>
