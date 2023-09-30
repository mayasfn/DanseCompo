<!-- SOUFAN Maya MEJRI Sarra -->
<?php

// permet d'afficher les informations reliées à un employé selectionné par l'utilisateur.
$info_employe = get_info_employe($connexion);

//Permet si l'utilisateur clique sur le bouton Modifier de modfier la fonction de l'employé séléctionné avant.
if (isset($_POST['Modifier'])) {
    if (!empty($_POST['nouv_fonction'])) {
        $nouv_fonction = $_POST['nouv_fonction'];
        $resultat = modifier_employe($connexion, $nouv_fonction);
        if ($resultat == true) {
            echo "Les informations de cet employé ont été modifié avec succès. \n";
        } else {
            echo "Erreur, Veuillez recommencer. \n";
        }
    }
} else {
    echo " <p class=info_employe> <br> La fonction de cet employé est : " . $info_employe['fonction'] . "<br> <br>\n";

    echo "Voulez-vous modifier la fonction de cet employé?  \n";

}


?>