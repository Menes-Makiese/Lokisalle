<?php
include("inc/init.inc.php");
include("inc/header.inc.php");
?>

<div class="container">
  <div class='box-filter'>
    <div class='filtres'>
      <div class='categories'>
        <?php
        // Sélection de toutes les catégories distinctes de la table salle
        $categories = $pdo->query("SELECT distinct(categorie) FROM salle");
        echo "<h2>Catégories</h2>";
        echo "<ul>";
        while ($categorie = $categories->fetch(PDO::FETCH_ASSOC)) {
          // Créer le lien de filtre par catégorie
          echo "<button class='btn btn-outline-secondary border btn-sm mt-2 p'><a href='?categorie=$categorie[categorie]' class=''>$categorie[categorie]</a></button><br>";
        }
        echo "<button class='btn btn-outline-secondary border btn-sm mt-2'><a href='?categorie=tout'>Voir tout</a></button>";
        echo "</ul>";
        ?>
      </div>

      <div class='villes'>
        <?php
        // Sélection de toutes les villes distinctes de la table salle
        $villes = $pdo->query("SELECT distinct(ville) FROM salle");
        echo "<h2>Villes</h2>";
        echo "<ul>";
        while ($ville = $villes->fetch(PDO::FETCH_ASSOC)) {
          // Créer le lien de filtre par ville
          echo "<button class='btn btn-outline-secondary border btn-sm mt-2 w-full'><a href='?ville=$ville[ville]'>$ville[ville]</a></button><br>";
        }
        echo "<button class='btn btn-outline-secondary border btn-sm mt-2'><a href='?ville=tout'>Voir tout</a></button>";
        echo "</ul>";
        ?>
      </div>
      <div class='disponibilite'>
        <?php
        // Sélection de toutes les etat distincts de la table produit
        $etats = $pdo->query("SELECT distinct(etat) FROM produit");
        echo "<h2>Etat</h2>";
        echo "<ul>";
        while ($etat = $etats->fetch(PDO::FETCH_ASSOC)) {
          // Créer le lien de filtre par etat
          echo "<button class='btn btn-outline-secondary border btn-sm mt-2 w-full'><a href='?etat=$etat[etat]'>$etat[etat]</a></button><br>";
        }
        echo "<button class='btn btn-outline-secondary border btn-sm mt-2'><a href='?ville=tout'>Voir tout</a></button>";
        echo "</ul>";
        ?>
      </div>
    </div>
  </div>

  <div class='fiches'>
    <?php
    // Construction de la requête SQL de base
    $sql = "SELECT salle.*, produit.* FROM salle JOIN produit ON produit.id_salle = salle.id_salle";
    $conditions = array();

    // Filtre par catégorie
    if (isset($_GET['categorie']) && $_GET['categorie'] != 'tout') {
      $conditions[] = "salle.categorie = '$_GET[categorie]'";
    }

    // Filtre par ville
    if (isset($_GET['ville']) && $_GET['ville'] != 'tout') {
      $conditions[] = "salle.ville = '$_GET[ville]'";
    }

    // Filtre par etat
    if (isset($_GET['etat']) && $_GET['etat'] != 'tout') {
      $conditions[] = "produit.etat = '$_GET[etat]'";
    }

    // Si des filtres sont appliqués, ajouter la clause WHERE
    if (count($conditions) > 0) {
      $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Exécution de la requête
    $produits = $pdo->query($sql);

    // Affichage des résultats
    while ($donnees = $produits->fetch(PDO::FETCH_ASSOC)) {
      echo "
        <div class='card' style='width: 18rem; height: 35rem;'>
          <img class='card-img-top' src='$donnees[photo]' alt='$donnees[titre]'/>
          <div class='card-body'>
            <h5 class='card-title'>$donnees[titre]</h5>
            <p class='card-text'>$donnees[description]</p>
          </div>
          <ul class='list-group list-group-flush'>
            <li class='list-group-item'>Du " . date('d F Y', strtotime($donnees['date_arrivee'])) . " au " . date('d F Y', strtotime($donnees['date_depart'])) . "</li>
            <li class='list-group-item'>$donnees[ville] - $donnees[categorie]</li>
            <li class='list-group-item'>Capacité : $donnees[capacite] personnes</li>
          </ul>
          <div class='card-body d-flex justify-content-between align-items-center'>
            <button class='btn btn-outline-success'><a href='fiche_produit.php?idSalle=$donnees[id_salle]' class='card-link'>Voir détails</a></button>
            <p>$donnees[prix] &euro;</p>
          </div>
        </div>";
    }
    ?>
  </div>
</div>

<?php
include('inc/footer.inc.php');
?>