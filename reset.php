<?php
require 'inc/bootstrap.php';
    if(isset($_GET['id']) && isset($_GET['token'])){
        $auth =  App::getAuth();
        $db = App::getDataBase();
        $user = $auth->checkResetToken($db, $_GET['id'],$_GET['token']);
        if($user){
            if(!empty($_POST)) {
                $validator = new Validator($_POST);
                $validator->isConfirmPWD('password');
                if ($validator->isValid()) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $reqUp = $db->query('UPDATE users SET reset_token = NULL, reset_at = NULL, password = ?  WHERE id=?' , [$password, $_GET['id']]);
                    Session::getInstance()->setFlash('success', "Votre mot de passe a bien été réinitialisé!");
                    App::redirect('account.php');
                } else {
                    Session::getInstance()->setFlash('danger', "Les deux mots de passe ne match pas!");
                    App::redirect('login.php');
                }
            }
        }else{
            Session::getInstance()->setFlash('danger', "ce compte est introuvable!");
            App::getAuth('login.php');
        }
    }else{
        App::getAuth('login.php');
    }
?>


<?php require 'inc/header.php';  ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Nouveau mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Confirmation nouveau mot de passe</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Réiniialiser</button>

</form>
<?php require 'inc/footer.php'; ?>
