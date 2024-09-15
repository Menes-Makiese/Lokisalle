<?php

include("inc/init.inc.php");
include("inc/header.inc.php");


session_destroy();

echo "<script> window.location.href='connexion.php';</script>";

include("inc/footer.inc.php");
