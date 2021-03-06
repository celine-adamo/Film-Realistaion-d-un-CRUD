<?php

require_once 'function.php';
reconnect_from_cookie();
if (isset($_SESSION['auth'])) {
    header('Location: account.php');
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    require_once 'db.php';
    session_start();
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username)');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    if ($user) {
        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] =  'Vous êtes maintenant connecté';
            if ($_POST['remember']) {
                $remember_token = str_random(250);
                $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
                setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
            }
            header('Location: account.php');
            exit();
        }
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}

?>

<?php require_once "header.php"; ?>


<h1>Se connecter</h1>
<!-- Formulaire d'enregistrement -->
<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo ou email</label>
        <input type="text" name="username" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement  du pseudo-->

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">(J'ai oublié mon mot de passe)</a> </label>
        <input type="password" name="password" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement du mot de passe -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="remember" value="1"> Se souvenir de moi
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Se connecter</button>
    <!-- Ajout d'un bouton -->

</form>

<?php require_once "footer.php"; ?>