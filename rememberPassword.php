<?php
require 'inc/bootstrap.php';
if(!empty($_POST) && !empty($_POST['email'])){
    $db = App::getDataBase();
    $auth = App::getAuth();
    $session = Session::getInstance();
    if($auth->resetPassWord($db, $_POST['email'])){
        $session->setFlash('success',  "un email de réinitialisation vous a été envoyé!");
        App::redirect('login.php');
    }else{
        $session->setFlash('danger', "Compte inexistant !!!!!");
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
