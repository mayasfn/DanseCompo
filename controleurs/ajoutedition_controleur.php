<!-- SOUFAN Maya MEJRI Sarra -->
<?php
//Si l'utilisateur clique sur le bouton Ajouter , on ajoute une edition avec son année, ville.
//Et dans la table participe les informations reliées à cette édition.
if (isset($_POST['Ajouter'])) {
    $année = $_POST['année'];
    $ville = $_POST['ville'];
    $rang = $_POST['rang'];
    $resultat = ajoute_edition($connexion, $annee, $ville);
    if ($resultat == true) {
        echo "Edition ajoutée avec succès.\n";
    } else
        echo "Erreur, veuillez recommencer.\n";

}
//Si l'utilisateur clique sur le bouton , on supprime une édition et toutes les informations qui y sont reliées de la base.
if (isset($_POST['Supprimer'])) {
    $année = $_POST['année'];
    $ville = $_POST['ville'];
    $resultat1 = supprimer_edit($connexion, $annee, $ville);
    if ($resultat1 == true) {
        echo "Suppression de l'édition avec succès.\n";
    } else
        echo "Erreur, veuillez recommencer.\n";
}

?>