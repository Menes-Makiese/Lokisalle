<?php

include("inc/init.inc.php");
include("inc/header.inc.php");
?>
<div class="jumbotron p-3 p-md-5 text-white bg-dark">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">LOKISALLE, la location qualitative </h1>
          <p class="lead my-3">Besoin d'un cadre de qualité pour organiser vos réunions ? Faites confiance à Lokisalle !</p>
          <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">...</a></p>
        </div>
</div>

      <div class="row mb-2 w-100 mt-4 m-0">
        <div class="col-md-6 mb-4 ">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-primary">Paris</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="fiche_produit.php?idSalle=1">SALLE STARK</a>
              </h3>
              <div class="mb-1 text-muted">Nov 12</div>
              <p class="card-text mb-auto">Profitez de notre salle modernes à Paris, équipées de technologies avancées, parfaites pour vos réunions et séminaires d'affaires.</p>
              <a href="fiche_produit.php?idSalle=1">Voir plus</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block w-50" src="./photo/1725880123_salle_baron.png" alt="Card image cap" >
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success">Marseille</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="fiche_produit.php?idSalle=7">SALLE FREY</a>
              </h3>
              <div class="mb-1 text-muted">Nov 11</div>
              <p class="card-text mb-auto">Réservez notre salle de réunion à Marseille, idéales pour des rencontres professionnelles, avec des équipements modernes.</p>
              <a href="fiche_produit.php?idSalle=7">Voir plus</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block w-50" src="./photo/1725881457_salle_frey.jpg" alt="Card image cap">
          </div>
        </div>
      </div>
    </div>
    <div class="blog-post row h-25 m-0 pb-5">
            <h2 class="blog-post-title fs-xs">Lokisalle c'est..</h2>
            <p>Leader incontesté de la location de salles en France pour les particuliers et les entreprises, Lokisalle vous met à disposition des salles de réunion de haute qualité à Paris, Lyon, Marseille et dans toute la France.Soucieux du bien être de vos collaborateurs, vous cherchez une solution efficace à la hauteur de vos exigences et de l'image de votre entreprise.N'attendez plus ! Inscrivez-vous sur notre site et réservez en quelques clics la salle qui répond à vos besoins.</p>
    </div>

<?php
include("inc/footer.inc.php");
