<!-- SOUFAN Maya MEJRI Sarra -->
<?php


//Si l'utilisateur clique sur ajouter (l'école) : 
if (isset($_POST['boutonValider'])) {
    $prénom = $_POST['prénom'];
    $nom = $_POST['nom'];
    $fonction = $_POST['fonction'];
    $resultat = ajoute_employe($connexion, $prénom, $nom);
    $resultat2 = ajoute_fonction($connexion, $fonction, $nom, $prénom);
    //vérification de la requête
    if ($resultat == true && $resultat2 == true) {
        echo "Employé ajouté avec succès.\n";
    } else
        echo "Erreur, veuillez recommencer.\n";


}

?>