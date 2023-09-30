<!-- SOUFAN Maya MEJRI Sarra -->
<?php
//appel aux fonctions qui vont afficher les informations voulus
$info = get_infofederation($connexion);
$adresseF = get_adressefede($connexion);
$nbCom = get_nbcomité($connexion);
$competitionF = get_listcompetition($connexion);
$nbadherant = get_nbadherant_compet($connexion);
$nbmembres = getnb_membresfede($connexion);
?> 