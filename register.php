<?php
require_once 'inc/bootstrap.php';

if(!empty($_POST)){
    $db = App::getDataBase();
    $errors = array();

    $validator = new Validator($_POST);
    $validator->isAlpha('username', 'Votre pseudo n\'est pas valide, il doit etre au format AlphaNumérique');
    if($validator->isValid()){
        $validator->isUniq('username', $db, 'users', 'Ce pseudo est déjà utilisé');
    }
    $validator->isEmail('email', 'Votre email n\'est pas valide');
    if($validator->isValid()){
        $validator->isUniq('email', $db, 'users', 'Cet Email est deja utilisé pour un autre compte!');
    }
    $validator->isConfirmPWD('password', 'Vos deux mots de passe ne sont pas les mêmes');

    if($validator->isValid()){
        $auth = App::getAuth();
        $auth->register($db, $_POST['username'], $_POST['password'], $_POST['email']);

        $session = Session::getInstance();
        $session->setFlash('success', 'un email de confirmation vous a été envoyé!');
        header('Location: login.php');
        exit();
    }else{
        $errors = $validator->getErrors();
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
