<?php

include("inc/init.inc.php");
include("inc/header.inc.php");
?>
<form class="form-signin w-50 mx-auto mt-4">
      <div class="text-center mb-4">
        <img class="mb-4" src="./inc/img/bd3f8963e5364dd4a35cd288498acc46-free.png" alt="" width="72" height="72">
        <p>Contactez-nous</p>
      </div>

      <div class="form-label-group">
        <label for="inputName">Votre nom</label>
        <input type="name" id="inputName" class="form-control" placeholder="Votre Nom" autofocus><br>
      </div>

      <div class="form-label-group">
        <label for="inputEmail">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus><br>
        
      </div>

      <div class="form-label-group">
      <label for="inputTextarea">Votre renseignement</label><br>
        <textarea name="" id="inputTextarea" placeholder="Que pouvons nous faire pour vous ?" cols="91" class=" form-control"></textarea><br>
      </div>

      
      <button class="btn btn-lg btn-primary btn-block" type="send">Envoyer</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; 2023-2024</p>
    </form>

<?php
include("inc/footer.inc.php");
