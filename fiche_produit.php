<?php

include("inc/init.inc.php");
include("inc/header.inc.php");

if (isset($_GET['idSalle'])) {
  // Requête pour les détails de la salle et du produit
  $produit = $pdo->query(
    "SELECT salle.*, produit.*
    FROM salle 
    JOIN produit ON salle.id_salle = produit.id_salle 
    WHERE salle.id_salle = '$_GET[idSalle]'"
  );

  $donnees = $produit->fetch(PDO::FETCH_ASSOC);

  // Si aucune salle trouvée, afficher une erreur
  if (!$donnees) {
    echo "<div class='alert alert-danger'>Erreur : Salle non trouvée.</div>";
    exit();
  }

  // Conteneur principal
  echo "<div class='d-flex mx-auto w-75 align-items-center h-75' >";

  // Image et message de réservation
  echo "<div class='d-flex flex-column w-50 position-relative' style='width: 100%;'>";
  echo "<img src='$donnees[photo]' style='width:100%;'/>";

  // Afficher le message si la salle est réservée
  if ($donnees['etat'] == 'reserver') {
    echo "<span class='alert alert-danger' style='position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); z-index:10; background-color:rgba(255,0,0,0.7); color:white; padding:10px; border-radius:5px;'>Cette salle est déjà réservée</span>";
  }

  echo "</div>"; // Fin du conteneur d'image

  // Informations sur la salle
  echo "<div class='d-flex flex-column w-50 lh-md text-wrap m-5'>";
  echo "<h2>" . $donnees['titre'] . "</h2>";
  echo "Categorie : $donnees[categorie]<br>";
  echo "Capacite: $donnees[capacite]<br>";
  echo "Description: $donnees[description]<br>";
  echo "Pays: $donnees[pays]<br>";
  echo "Ville: $donnees[ville] - $donnees[cp]<br>";
  echo "Adresse: $donnees[adresse]<br>";
  echo "Disponibilité: $donnees[etat]<br>";
  echo "Date: " . date('d F Y', strtotime($donnees['date_arrivee'])) . " au " . date('d F Y', strtotime($donnees['date_depart'])) . '<br>';
  echo "Prix: " . $donnees['prix'] . "€";
  echo "<a href='avis.php?idSalle=$donnees[id_salle]' class='btn btn-outline-primary'>Donnez votre avis</a>";
  echo "</div></div>";

  // Requête pour les avis
  $avis = $pdo->query(
    "SELECT avis.*, membre.nom
    FROM avis
    JOIN membre ON avis.id_membre = membre.id_membre
    WHERE avis.id_salle = '$_GET[idSalle]'"
  );

  echo "<section style='background-color: #ad655f;'>
  <h3 class='text-center pt-4'>AVIS</h3>
  <div class='container my-5 py-5'>
    <div class='row d-flex justify-content-center'>
      <div class='col-md-12 col-lg-10'>
      ";

  // Boucle pour afficher les avis
  while ($avis_donnee = $avis->fetch(PDO::FETCH_ASSOC)) {
    echo "
        <div class='card text-body'>
          <div class='card-body p-4'>
            <h4 class='mb-0'>Commentaire de " . $avis_donnee['nom'] . "</h4>
            <p class='fw-light mb-4 pb-2'>Note : " . $avis_donnee['note'] . "/5</p>

            <div class='d-flex flex-start'>
              <img class='rounded-circle shadow-1-strong me-3'
                src='./inc/img/user.png' alt='avatar' width='60'
                height='60' />
              <div>
                <p class='mb-0'>
                  " . $avis_donnee['commentaire'] . "
                </p>
              </div>
            </div>
          </div>
          <hr class='my-0' />
        </div>";
  }

  echo "</div></div></div></section>";

  // Formulaire de réservation si la salle n'est pas réservée
  if ($donnees['etat'] != 'reserver') {
?>
    <form action="panier.php" method="post" class="d-flex justify-content-center">
      <input type="hidden" name="id_salle" value="<?= $_GET['idSalle'] ?>">
      <input type="hidden" name="prix" value="<?= $donnees['prix'] ?>">
      <input type="hidden" name="photo" value="<?= $donnees['photo'] ?>">
      <input type="hidden" name="date_arrivee" value="<?= $donnees['date_arrivee'] ?>">
      <input type="hidden" name="date_depart" value="<?= $donnees['date_depart'] ?>">
      <input type="submit" value="Réserver" class='btn btn-outline-success mt-2 mb-5'>
    </form>
<?php
  }
}

include("inc/footer.inc.php");
?>