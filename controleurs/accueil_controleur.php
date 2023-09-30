<!-- SOUFAN Maya MEJRI Sarra -->
<?php
global $login;

$nbrs = get_nb_federations($connexion);
$nb_ecole = get_nb_ecole_par_depart($connexion);
$comite_reg = get_comites_reg($connexion);
$top_ecole = get_top_ecole($connexion);



//la variable login servira pour afficher le bon menu en fonction de l'identification choisie
if (isset($_POST['Ecole'])) {

    $login = "Ecole";
    $_SESSION['login'] = "Ecole";
    header("Location: index.php?page=identification");
    exit();

}
if (isset($_POST['Fédération'])) {

    $login = "Fédération";
    $_SESSION['login'] = "Fédération";
    header("Location: index.php?page=identificationfede");
    exit();

}

?>