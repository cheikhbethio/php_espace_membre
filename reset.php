<?php
   /* $_GET['id'] =$_GET['id'];
    $_GET['token'] = $_GET['token'];
    $_POST['password'] = $_POST['password'];
    $_POST['password_confirm'] = $_POST['password_confirm'];*/
    session_start();
    if(isset($_GET['id']) && isset($_GET['token'])){
        require 'inc/db.php';
        //chercher luser avec son id veirier si le reset token est bon
        $req = $pdo->prepare('SELECT * from users WHERE id=? AND  reset_token=? AND reset_at > DATE_SUB(NOW(), INTERVAL 230 MINUTE)');
        $req->execute([$_GET['id'],$_GET['token']]);
        $user = $req->fetch();
        //faire le update si tout est ok
        if($user){
            if(!empty($_POST)) {
                if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $reqUp = $pdo->prepare('UPDATE users SET reset_token = NULL, reset_at = NULL, password = ?  WHERE id=?');
                    $reqUp->execute([$password, $_GET['id']]);
                    $_SESSION['flash']['success'] = "Votre mot de passe a bien été réinitialisé!";
                    header('Location: login.php');
                    exit();
                } else {
                    $_SESSION['flash']['danger'] = "Les deux mots de passe ne match pas!";
                    var_dump($_POST['password']);
                    var_dump($_POST['password_confirm']);
                    /*header('Location: login.php');
                    exit();*/
                }
            }
        }else{
            //message falsh et redirection
            $_SESSION['flash']['danger'] = "ce compte est introuvable!";
            header('Location: login.php');
            exit();
        }
    }else{
        header('Location: login.php');
        exit();
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
