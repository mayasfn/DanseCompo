<!-- SOUFAN Maya MEJRI Sarra -->
<?php

//Si l'utilisateur choisi de modifier la fédération: quand il clique sur valider les changements seront faits
if (isset($_POST['Valider'])) {

    //Si l'utilisateur choisi de modifier le nom:  (si la case dans le form n'est pas vide, c'est modifié)
    if (!empty($_POST['nom'])) {
        $nom = $_POST['nom'];
        $resultatn = modifier_fede($connexion, $nom);
        //vérification de la requête
        if ($resultatn == true) {
            echo "Nom modifié avec succès.\n";

        } else
            echo "Erreur, modification du nom a échoué.\n";

    }

    //Si l'utilisateur choisi de modifier l'adresse: 

    //pour le numéro de voie: (si la case dans le form n'est pas vide, c'est modifié)
    if (!empty($_POST['numvoie'])) {
        $numvoie = $_POST['numvoie'];
        $resultatnv = modifier_numvoief($connexion, $numvoie);
        //vérification de la requête
        if ($resultatnv == true) {
            echo "Numéro de voie modifié avec succès.\n";

        } else
            echo "Erreur, modification du numéro de voie a échoué.\n";
    }

    //pour la rue : (si la case dans le form n'est pas vide, c'est modifié)
    if (!empty($_POST['rue'])) {
        $rue = $_POST['rue'];
        $resultatr = modifier_ruef($connexion, $rue);
        //vérification de la requête
        if ($resultatr == true) {
            echo "Rue modifiée avec succès.\n";

        } else
            echo "Erreur, modification de la rue a échouée.\n";
    }

    //pour le cp : (si la case dans le form n'est pas vide, c'est modifié)
    if (!empty($_POST['cp'])) {
        $cp = $_POST['cp'];
        $resultatc = modifier_cpfede($connexion, $cp);
        //vérification de la requête
        if ($resultatc == true) {
            echo "Code postale modifié avec succès.\n";

        } else
            echo "Erreur, modification du code postal a échoué.\n";
    }

    //pour la ville : (si la case dans le form n'est pas vide, c'est modifié)
    if (!empty($_POST['ville'])) {
        $ville = $_POST['ville'];
        $resultatv = modifier_villef($connexion, $ville);
        //vérification de la requête
        if ($resultatv == true) {
            echo "Ville modifiée avec succès.\n";

        } else
            echo "Erreur, modification de la ville a échouée.\n";
    }


}





?>