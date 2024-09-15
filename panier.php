<?php

include("inc/init.inc.php");

// Nombre d'articles dans le panier
$nbProduitsPanier = isset($_SESSION['panier']['id_salle']) ? count($_SESSION['panier']['id_salle']) : 0;

include("inc/header.inc.php");


// SUPPRESSION D'UN PRODUIT DANS LE PANIER
if (isset($_GET['action']) and $_GET['action'] == 'supprimer') {
  unset($_SESSION['panier']['id_salle'][$_GET['position']]);
  unset($_SESSION['panier']['photo'][$_GET['position']]);
  unset($_SESSION['panier']['titre'][$_GET['position']]);
  unset($_SESSION['panier']['date_arrivee'][$_GET['position']]);
  unset($_SESSION['panier']['date_depart'][$_GET['position']]);
  unset($_SESSION['panier']['prix'][$_GET['position']]);
}

if (isset($_POST['id_salle'])) {
  // on selectionne le produit qui contient l'id envoyé en POST (càd la valeur de id_produit)
  $produit = $pdo->query("SELECT * FROM salle  WHERE id_salle='$_POST[id_salle]'");
  // vu que $produit n'est pas exploitable, on utilise la fonction fetch pour récupérer chaque ligne de la table produit et de le convertir en tableau associatif
  $produit_choisi = $produit->fetch(PDO::FETCH_ASSOC);
  //    debug($produit_choisi);


  ajouterAuPanier($produit_choisi['id_salle'], $_POST['photo'], $produit_choisi['titre'], $_POST['date_arrivee'], $_POST['date_depart'], $_POST['prix']);


  //debug($_SESSION['panier']);
}


?>
<h3 class="text-center mt-5">Votre Panier</h3>
<table class='table w-75 mx-auto mt-5'>
  <tr>
    <th>Titre</th>
    <th>Prix</th>
    <th>Date/heure d'arrivée</th>
    <th>Date/heure depart</th>
    <th>Action</th>
  </tr>
  <?php


  if (isset($_SESSION['panier']['id_salle']) and !empty($_SESSION['panier']['id_salle'])) {
    for ($i = 0; $i < count($_SESSION['panier']['id_salle']); $i++) {
      // Conversion et formatage de la date d'arrivée
      $date_arrivee = new DateTime($_SESSION['panier']['date_arrivee'][$i]);
      $date_depart = new DateTime($_SESSION['panier']['date_depart'][$i]);

      $date_arrivee_formatee = $date_arrivee->format('d F Y - H\hi');
      $date_depart_formatee = $date_depart->format('d F Y - H\hi');
      echo "<tr><td>" . $_SESSION['panier']['titre'][$i] . " - <img src='" . $_SESSION['panier']['photo'][$i] . "' width=80/>" . "</td><td>" . $_SESSION['panier']['prix'][$i] . " €" . "</td><td>" . $date_arrivee_formatee . "</td><td>" . $date_depart_formatee . "</td><td><a href='?action=supprimer&position=" . $i . "'><img src='./inc/img/effacer.png' width=25 title='supprimer'/></a></td></tr>";
    }
    // prixTotal() est executé dans le fichier init.inc.php
    echo "<tr><th></th><th></th><th></th><th>Prix total</th><th>" . prixTotal() . "</th></tr>";
  } else {
    echo "<tr><td></td><td>le panier est vide</td></tr>";
  }
  ?>
</table>
<?php

if (isset($_SESSION['panier']['id_salle']) and !empty($_SESSION['panier']['id_salle'])) {
  echo "<div class='d-flex align-items-center'><button class='btn btn-outline-success mx-auto'><a href='validation.php'>Valider Panier</a></button></div>";
} else {
  echo "<div class='d-flex align-items-center'><a href='location.php' class='btn btn-outline-primary mx-auto'>Retour aux locations</a></div>";
}
