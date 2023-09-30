<!-- SOUFAN Maya MEJRI Sarra -->
<?php
//Variables qui sauvegarde si un bouton a été cliqué ou pas, pour savoir quel fonctionalité l'utilisateur veut faire
$ajoutercompet = isset($_POST['ajoutercompet']);
$supprimercompet = isset($_POST['supprimecompet']);

$nomcom = get_nomcomite($connexion);
$resultats = get_competition($connexion);

//Quand l'utilisateur choisi une compétition, elle est sauvegardée dans une variable globale
if (isset($_POST['Valider'])) {
    global $compet;
    $compet = $_POST['competition'];
    $_SESSION['compet'] = $_POST['competition'];
    header("Location: index.php?page=infocompet");
    exit();
}

//Si l'utilisateur choisi d'ajouter une compétition: 
if (isset($_POST['ajoute'])) {
    //ce que l'utilisateur a saisit est sauvegardé dans des variables
    $code = $_POST['codec'];
    $libellé = $_POST['libellé'];
    $niveau = $_POST['niveau'];
    $comite = $_POST['comite'];

    //si aucun des cases dans le form sont vides: 
    if (!empty($code) && !empty($libellé) && !empty($niveau) && !empty($comite)) {
        $resultatc = ajouter_competition($connexion, $libellé, $code, $niveau);
        //vérification de la requête
        if ($resultatc == true && $resultatgere == true)
            echo "Compétition ajouté avec succès";
        else
            echo "Erreur lors de l'ajoute de compétition";
        $resultatgere = ajouter_gere($connexion, $code, $comite);
    } else
        echo "Veuillez remplir toutes les cases";

}

//Si l'utilisateur choisi de supprimer une compétition: 
if (isset($_POST['supprimer'])) {

    //ce que l'utilisateur a saisit est sauvegardé dans des variables
    $libellé = $_POST['supprime'];

    $resultatg = supprime_gere($connexion, $libellé);
    $resultatc = supprime_compet($connexion, $libellé);
    //vérification de la requête
    if ($resultatc == true && $resultatg == true)
        echo "Compétition supprimée avec succès";
    else
        echo "Erreur lors de la suppression de compétition";

}


?>