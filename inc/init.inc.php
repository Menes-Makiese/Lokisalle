<?php
session_start();


$pdo = new PDO('mysql:host=localhost;dbname=lokisalle', 'root', '');



define("RACINE_SITE", "/evaluation_backend_menes_makiese/");


function isConnected()
{

  if (isset($_SESSION['membre']['statut']) and $_SESSION['membre']['statut'] == 'membre') {
    return true;
  } else {
    return false;
  }
};

function isConnectedAndAdmin()
{
  if (isset($_SESSION['membre']['statut']) and $_SESSION['membre']['statut'] == 'admin') {
    return true;
  } else {
    return false;
  }
}

function debug($val)
{
  echo "<pre>";
  print_r($val);
  echo "</pre>";
}

function creationPanier()
{
  // si le panier n'existe pas crée le moi

  if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
    $_SESSION['panier']['id_salle'] = [];
    $_SESSION['panier']['titre'] = [];
    $_SESSION['panier']['date_arrivee'] = [];
    $_SESSION['panier']['date_depart'] = [];
    $_SESSION['panier']['prix'] = [];
  }
}

function  ajouterAuPanier($id_salle, $photo, $titre, $date_arrivee, $date_depart, $prix)
{
  //avant de mettre le produit dans le panier, on crée le panier
  creationPanier();
  //on cherche si le produit est présent dans le panier
  // si il est présent , ça retournera la clé correspondante
  // si non présent , ça retournera false
  //chercher moi l'id produit a l'interieur de la session panier avec l'id produiit
  $position = array_search($id_salle, $_SESSION['panier']['id_salle']);


  if ($position === false) {
    // si le produit existe deja dans le panier

    $_SESSION['panier']['id_salle'][] = $id_salle;
    $_SESSION['panier']['titre'][] = $titre;
    $_SESSION['panier']['photo'][] = $photo;
    $_SESSION['panier']['date_arrivee'][] = $date_arrivee;
    $_SESSION['panier']['date_depart'][] = $date_depart;
    $_SESSION['panier']['prix'][] = $prix;
  } else {
    //si on vient juste d'ajouter un nouveau produit dans le panier 

  }
}

function prixTotal()
{
  $total = 0;

  for ($i = 0; $i < count($_SESSION['panier']['id_salle']); $i++) {
    $total += $_SESSION['panier']['prix'][$i];
  }

  return $total . "&euro;";
}

function prixTotalCommandes($commandes)
{
  $totalPrix = 0;

  // Parcours du tableau des commandes
  foreach ($commandes as $commande) {
    // Addition du prix de chaque commande au total
    $totalPrix += $commande['prix'];
  }

  // Retourne le total formaté avec deux décimales
  return number_format($totalPrix, 0);
}
