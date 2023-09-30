<!-- SOUFAN Maya MEJRI Sarra -->
<?php

//Si l'utilisateur clique sur ajouter (fédération) : 
if (isset($_POST['Valider'])) {
    $nom = $_POST['nom'];
    $sigle = $_POST['sigle'];
    $président = $_POST['président'];
    $resultat = ajoute_fédération($connexion, $nom, $sigle, $président);
    //vérification de la requête
    if ($resultat == true) {
        echo "Fédération ajouté avec succès.\n";
    } else
        echo "Erreur, veuillez recommencer.\n";


}

?>