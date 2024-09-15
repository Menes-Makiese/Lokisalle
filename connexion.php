<?php

include("inc/init.inc.php");
include("inc/header.inc.php");

$message = "";
$messageNonInscrit = "";

if (!empty($_POST)) {
  $identifiant = $_POST['pseudo'];
  $mdp = md5($_POST['mdp']);
  $membre = $pdo->query("SELECT * from membre WHERE pseudo = '$identifiant' or email = '$identifiant' ");

  if ($membre->rowCount() >= 1) {
    // ici, on n'a pas besoin d'utiliser un while car on veut juste recuperer une seule ligne
    $donnees = $membre->fetch(PDO::FETCH_ASSOC);
    // on verifie est ce que le mot de passe de ce membre est egal au mot de passe envoyé par le formulaire
    if ($donnees['mdp'] == md5($_POST['mdp'])) {
      $_SESSION['membre']['id_membre'] = $donnees['id_membre'];
      $_SESSION['membre']['pseudo'] = $donnees['pseudo'];
      $_SESSION['membre']['prenom'] = $donnees['prenom'];
      $_SESSION['membre']['nom'] = $donnees['prenom'];
      $_SESSION['membre']['civilite'] = $donnees['civilite'];
      $_SESSION['membre']['email'] = $donnees['email'];
      $_SESSION['membre']['statut'] = $donnees['statut'];
      $_SESSION['membre']['date_enregistrement'] = $donnees['date_enregistrement'];


      echo "<script> window.location.href='accueil.php';</script>";
    } else {
      $message = "<button class='mb-0 btn btn-lg btn-secondary'>Le mot de passe est incorrect</button>";
    }
  } else {
    $messageNonInscrit = "Aucun compte reconnu";
    $message = "<button class='mb-0 btn btn-lg btn-primary'><a href='inscription.php'>Inscrivez-vous</a></button>";
  }
}

?>


<form class="form-signin w-50 mx-auto mt-4" action="#" method="POST">
  <div class="text-center mb-4">
    <img class="mb-4" src="./inc/img/bd3f8963e5364dd4a35cd288498acc46-free.png" alt="" width="72" height="72">
    <h2>Connectez-Vous</h2>
  </div>

  <div class="form-label-group">
    <label for="inputName">Pseudo ou Email</label>
    <input type="text" id="inputName" name="pseudo" class="form-control" placeholder="Votre pseudo ou adresse email" required autofocus autocomplete="username"><br>

  </div>

  <div class="form-label-group">
    <label for="inputPassword">Mot de Passe</label>
    <input type="password" id="inputPassword" name="mdp" class="form-control" placeholder="Votre mot de passe" required autocomplete="password"><br>

  </div>

  <div class="d-flex justify-content-between align-items-center">
    <input class="btn btn-lg btn-primary" type="submit" value="Se connecter">
    <?php
    // Affichage du message d'inscription si nécessaire
    echo $messageNonInscrit;
    echo $message;
    ?>
  </div>
  <p class="mt-5 mb-3 text-muted text-center">&copy; 2023-2024</p>
</form>








<?php

include("inc/footer.inc.php");
