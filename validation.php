<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['membre']['id_membre'])) {
  echo "<script> window.location.href='connexion.php';</script>";

  exit;  // On arrête l'exécution du script après la redirection
}

$id_membre = $_SESSION['membre']['id_membre']; // Récupérer l'id du membre connecté
$date_achat = date('Y-m-d H:i:s'); // Date actuelle au format MySQL

// Parcourir le panier et insérer les produits dans la table commande
if (isset($_SESSION['panier']['id_salle']) && !empty($_SESSION['panier']['id_salle'])) {
  for ($i = 0; $i < count($_SESSION['panier']['id_salle']); $i++) {
    $id_salle = $_SESSION['panier']['id_salle'][$i]; // L'id de la salle

    // Insérer la commande dans la table commande
    $insertCommande = $pdo->prepare("INSERT INTO commande (id_membre, id_produit, date_enregistrement) VALUES (:id_membre, :id_produit, :date_enregistrement)");
    $insertCommande->execute([
      ':id_membre' => $id_membre,
      ':id_produit' => $id_salle,
      ':date_enregistrement' => $date_achat,
    ]);

    // Mettre à jour l'état de la salle dans la table produit
    $updateSalle = $pdo->prepare("UPDATE produit SET etat = 'reserver' WHERE id_salle = :id_produit");
    $updateSalle->execute([
      ':id_produit' => $id_salle,
    ]);
  }

  // Vider le panier après l'achat
  unset($_SESSION['panier']);

  // Message de confirmation
  echo "<p>Merci pour votre achat ! Votre commande a été validée.</p>";
  echo "<a href='accueil.php' class='btn btn-outline-success'>Retour à l'accueil</a>";
} else {
  echo "<p>Votre panier est vide.</p>";
  echo "<a href='location.php' class='btn btn-outline-primary'>Retour aux locations</a>";
}

include("inc/footer.inc.php");
