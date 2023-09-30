<!-- SOUFAN Maya MEJRI Sarra -->
<?php
//variable pour avoir le bon affichage par rapport à quel filtre l'utilisateur a choisi
// et pour sauvegarder les listes générés sur la page tant que l'utilisateur a pas choisi de générer une nouvelle
global $choix, $listedanseurs, $list, $orgacom, $listo, $ville, $liste_orga;

$listedanseurs = isset($_POST['validerdanseurs']);
$orgacom = isset($_POST['validerorga']) && isset($_POST['nbm']);

if (isset($_POST['retourd'])) {
    $_SESSION['listedanseurs'] = null;
    $_SESSION['list'] = null;
    $_SESSION['choix'] = null;

}
if (isset($_POST['retourc'])) {
    $_SESSION['orgacom'] = null;
    $_SESSION['listo'] = null;
    $_SESSION['ville'] = null;
    $_SESSION['liste_orga'] = null;

}

//Appel des fonctions par rapport à ce que l'utilisateur à rentrer dans le form, 
//quel paramètres il a choisi pour la liste des danseurs
if ($listedanseurs) {
    $_SESSION['listedanseurs'] = true;
    $taille = intval($_POST['taille']);
    $nb = intval($_POST['nb']);

    if (!empty($taille) && isset($_POST['inclure'])) {
        $resultat = taille_palmares($connexion, $taille, $nb);
        $_SESSION['list'] = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
        $_SESSION['choix'] = 2;
    } else {
        if (!empty($taille)) {
            $resultat = list_adhe_taille($connexion, $taille, $nb);
            $_SESSION['list'] = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
            $_SESSION['choix'] = 'ecole';
        }
        if (isset($_POST['inclure'])) {
            $_SESSION['choix'] = 'palmares';
            $resultat = liste_top_danseurs($connexion, $nb);
            $_SESSION['list'] = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
        }
    }

}

//Appel des fonctions par rapport à ce que l'utilisateur à rentrer dans le form, 
//quel paramètres il a choisi pour la liste des organisateurs
if ($orgacom) {
    $_SESSION['orgacom'] = true;
    $numedi = $_POST['nbeditions'];
    $nbedi = intval($_POST['nbeditions']);
    $nbO = intval($_POST['nbm']);
    $_SESSION['liste_orga'] = nbedition_com($connexion, $nbedi, $nbO);
    $_SESSION['listo'] = mysqli_fetch_all($_SESSION['liste_orga'], MYSQLI_ASSOC);

    $liste_orga = nbedition_com($connexion, $nbedi, $nbO);
    $villes = mysqli_fetch_array($liste_orga);
    $ville = array();
    $ville = $villes['ville'];
    $_SESSION['ville'] = $ville;


}





?>