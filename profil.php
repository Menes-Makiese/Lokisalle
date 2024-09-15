<?php
include("inc/init.inc.php");
include("inc/header.inc.php");

echo "<h2>INFORMATIONS PERSONNELLES</h2>";

// Debug pour afficher les données de session
// debug($_SESSION['membre']);

if (isset($_SESSION['membre'])) {
  echo "Pseudo : " . $_SESSION['membre']["pseudo"] . '<br>';
  echo "Prenom : " . $_SESSION['membre']["prenom"] . '<br>';
  echo "Nom : " . $_SESSION['membre']["nom"] . '<br>';
  echo "Email : " . $_SESSION['membre']["email"] . '<br>';
  echo "Civilite : " . $_SESSION['membre']["civilite"] . '<br>';
  echo "Statut : " . $_SESSION['membre']['statut'] . '<br>';
  echo "Date d'enregistrement : " . $_SESSION['membre']['date_enregistrement'] . '<br>';

  // Récupérer l'ID du membre connecté
  $id_membre_connecte = $_SESSION['membre']['id_membre'];

  // Requête SQL pour récupérer les commandes du membre connecté
  try {
    $commandes = $pdo->prepare("SELECT
                commande.*,
                produit.prix,
                produit.date_arrivee,
                produit.date_depart,
                salle.titre
            FROM commande
            JOIN salle ON commande.id_produit = salle.id_salle
            JOIN produit ON commande.id_produit = produit.id_salle
            WHERE commande.id_membre = ?
            ORDER BY commande.date_enregistrement DESC");

    $commandes->execute([$id_membre_connecte]);

    // Convertir en tableau associatif
    $liste_commandes = $commandes->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

  // Affichage des commandes du membre connecté
  if (!empty($liste_commandes)) {
    echo "<h3 class='text-center'>Vos commandes</h3>";
    echo "<table class='table w-75 mx-auto'>";
    echo "<thead>
            <tr>
              <th scope='col'>ID Commande</th>
              <th scope='col'>ID Produit</th>
              <th scope='col'>Titre</th>
              <th scope='col'>Prix</th>
              <th scope='col'>Date Evenement</th>
              <th scope='col'>Date/heure d'achat</th>
            </tr>
          </thead>
          <tbody>";

    foreach ($liste_commandes as $commande) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($commande['id_commande']) . "</td>";
      echo "<td>" . htmlspecialchars($commande['id_produit']) . "</td>";
      echo "<td>" . htmlspecialchars($commande['titre']) . "</td>";
      echo "<td>" . htmlspecialchars($commande['prix']) . " €</td>";
      echo "<td>" . date('d F Y - H:i', strtotime($commande['date_arrivee'])) . "<br>" . date('d F Y - H:i', strtotime($commande['date_depart'])) . "</td>";
      echo "<td>" . date('d F Y - H:i', strtotime($commande['date_enregistrement'])) . "</td>";
      echo "</tr>";
    }

    echo "</tbody></table>";
  } else {
    echo "<h3 class='text-center'>Vos commandes</h3>";
    echo "<table class='table w-75 mx-auto'>><tbdody><tr><td>Aucune commande trouvée pour votre compte.</td></tr></tbdody></table>";
  }
} else {
  header("location:connexion.php");
}

include("inc/footer.inc.php");
