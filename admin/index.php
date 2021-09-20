<?php
    session_start();
    if (isset($_POST['username'])) {
        if (!empty($_POST['username']) and !empty($_POST['password'])) {
            require '../connexion.php';
            $password = $_POST['password'];
            $username = $_POST['username'];
            $req = $bdd->prepare('SELECT * FROM admin WHERE name = ?');
            $req->execute([$username]);
            if ($don = $req->fetch()) {
                if (password_verify($password, $don['password'])) {
                    $_SESSION['login'] = $username;
                    header("LOCATION:dashboard.php");
                } else {
                    $error = "Le mot de passe est incorrect";
                }
            } else {
                $error = 'Nous n\'avons pas de login portant ce nom';
            }
        } else {
            $error = 'Veuillez remplir correctement le formulaire';
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration | Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>

<h1 class="text-center mt-3">Administration</h1>

<?php if (isset($error)) echo '<p class="alert alert-danger">' . $error . '</p>' ?>
<form class="container w-25 mt-5" action="index.php" method="POST">
    <div class="form-group">
        <label class="form-label" for="username">Login :</label>
        <input class="form-control" type="text" id="username" name="username">
    </div>
    <div class="form-group">
        <label class="form-label" for="password">Password :</label>
        <input class="form-control" type="password" id="password" name="password">
    </div>
    <input class="btn btn-primary mt-3" type="submit" value="Connexion">
</form>
</body>
