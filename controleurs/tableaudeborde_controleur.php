<!-- SOUFAN Maya MEJRI Sarra -->
<?php

//appel aux fonctions qui vont afficher les informations voulus
$nomE = get_nom_by_fondepar($connexion);
$adresseE = get_adresse_by_fondepar($connexion);
$employeE = get_employe_by_fondepar($connexion);


$nbinscritE = get_nbinscrits_by_fondepar_annee($connexion);
$coursE = get_liste_cours_by_fondepar($connexion);
$nbAdheCompE = get_nb_adh_comp_by_fondepar($connexion);

?>