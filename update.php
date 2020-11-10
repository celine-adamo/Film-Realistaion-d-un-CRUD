<?php
require_once "header.php";
require_once 'db.php';

$req = $pdo->prepare('SELECT  films.id,films.title,films.synopsis,films.id_user FROM films WHERE films.id=?');
$req->execute([intval($_GET['id'])]);
$film = $req->fetch();
?>

<form action="" method="POST">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" class="form-control" value="<?php echo  $film->title?>" />
    </div>

    <div class="form-group">
        <label for="synopsis">Synopsis</label>
        <textarea class="form-control" id="synopsis" rows="3" name="synopsis"><?php echo  $film->synopsis?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Soumettre mon idée</button>
</form>
