
<?php
session_start();
require_once 'inc/functions.php';

require_once 'inc/db.php';
if(!empty($_POST)){
    $errors = array();
    if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username'] = 'Votre pseudo n\'est pas valide';
    }else{
        $req = $pdo->prepare('SELECT * FROM users WHERE username=?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = 'Ce pseudo est déjà utilisé';
        }
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Votre email n\'est pas valide';
    }
    if(empty($_POST['password']) || $_POST['password']!=$_POST['password_confirm']){
        $errors['password'] = 'Vos deux mots de passe ne sont pas les mêmes';
    }
    if(empty($errors)){
        $req = $pdo->prepare("insert into users set email =  ?, password =  ?, username =  ?, confirmation_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(70);
        $res = $req->execute([$_POST['email'], $password, $_POST['username'], $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], 'confirmation de votre compte', "Pour valider votre compte cliquez sur ce lien :
        http://localhost/tuto/php_espace_membre/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = "un email de confirmation vous a été envoyé!";
        header('Location: login.php');
        exit();
    }
}
?>
<?php require 'inc/header.php';?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">
        <p>Le formulaire n'est pas correctement rempli</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?=$error;?></li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Confirmation de mot de passe</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">M'INSCRIRE</button>

</form>

<?php require 'inc/footer.php';?>
