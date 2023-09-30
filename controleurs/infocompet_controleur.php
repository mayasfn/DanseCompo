<!-- SOUFAN Maya MEJRI Sarra -->
<?php

//Variables qui sauvegarde si un bouton a été cliqué ou pas, pour savoir quel fonctionalité l'utilisateur veut faire
$modifiercompet = isset($_POST['infocompet']);
$modifieredition = isset($_POST['modifie_edition']);
$inscrire = isset($_POST['inscrire']);
$rang = isset($_POST['rang']);
$ajouteredition = isset($_POST['ajouteredition']);
$supprimeredition = isset($_POST['supprime_edition']);
$idgdchoisie = isset($_POST['valideridgd']);
$modifedition = isset($_POST['selectedition']);


$edition = liste_edition($connexion);
$edition1 = liste_edition($connexion);
$editionL = liste_edition($connexion);
$niveauC = get_nivcompet($connexion);
$adherant1 = get_adherant($connexion);
$adherant2 = get_adherant($connexion);
$editionC = liste_edition($connexion);
$idgd = get_idgd($connexion);

//Si l'utilisateur choisi de modifier la compétition: 
if (isset($_POST['Modifiercompet'])) {
    //S'il modifie le nom : 
    if (!empty($_POST['nom'])) {
        $nom = $_POST['nom'];
        $_SESSION['compet'] = $_POST['nom'];
        $resultatn = modifier_libellécompet($connexion, $nom);
        //vérification de la requête
        if ($resultatn == true)
            echo "Libellé de la compétition modifié avec succès.\n";
        else
            echo "Erreur, modification du libellé a échoué.\n";

    }
    //S'il choisit de modifier le niveau
    if (!empty($_POST['niveau'])) {
        $nouvniveau = $_POST['niveau'];
        $resultat = modifier_nivcompet($connexion, $nouvniveau);
        //vérification de la requête
        if ($resultat == true)
            echo "Niveau de la compétition modifié avec succès.\n";
        else
            echo "Erreur, modification du niveau a échoué.\n";

    }
}

//Si l'utilisateur choisi de modifier son édition: 

//Choix de l'édition sauvegardé
if (isset($_POST['selectedition'])) {
    $edition = $_POST['edition'];
    // Séparer l'année et la ville de l'édition
    list($annee, $ville) = explode(", ", $edition);
    global $edi_annee, $edi_ville;
    // Sauvegarder l'année et la ville dans des variables
    $edi_annee = $annee;
    $edi_ville = $ville;
    $_SESSION['edi_annee'] = $annee;
    $_SESSION['edi_ville'] = $ville;

}

//Modifications voulus à l'édition choisie: 
if (isset($_POST['ModifierE'])) {

    //Si l'utilisateur veut modifier toutes les informations de l'édition (année, ville et structure sportive)
    if (!empty($_POST['annee']) && (!empty($_POST['ville'])) && (!empty($_POST['structure_sportive_nom'])) && (!empty($_POST['structure_sportive_type']))) {
        $annee_nouvelle = $_POST['annee'];
        $nouvelle_ville = $_POST['ville'];
        $nom = $_POST['structure_sportive_nom'];
        $type = $_POST['structure_sportive_type'];
        $resultat = modifier_annee_edit($connexion, $annee_nouvelle);
        $resultat2 = modifier_ville_edit($connexion, $nouvelle_ville, $annee_nouvelle);
        $resultat3 = ajoute_structure($connexion, $nom, $type);
        $resultat4 = ajoute_sederouledans($connexion, $nom, $type, $annee_nouvelle);
        if ($resultat == true && $resultat2 == true && $resultat3 == true && $resultat4 == true) {
            echo "Modifiaction de toutes les informations de cette édition avec succès!\n";
        } else
            echo "Erreur, veuillez recommencer.\n";
    } else {
        //S'il veut modifier  la ville, et remplit la case ville dans le form: 
        if (!empty($_POST['ville'])) {
            $nouvelle_ville = $_POST['ville'];
            $resultat2 = modifier_ville_edit($connexion, $nouvelle_ville, $_SESSION['edi_annee']);
            if ($resultat2 == true) {
                echo "Modifiaction de la ville de l'édition avec succès.\n";
            } else
                echo "Erreur avec la ville , veuillez recommencer.\n";

        }

        //S'il veut modifier  l'année, et remplit la case année dans le form: 
        if (!empty($_POST['annee'])) {
            $annee_nouvelle = $_POST['annee'];
            $resultat = modifier_annee_edit($connexion, $annee_nouvelle);
            if ($resultat == true) {
                echo "Modifiaction de l'année de l'édition avec succès.\n";
            } else
                echo "Erreur avec l'année, veuillez recommencer.\n";
        }

        //S'il veut modifier  le nom et le type de la structure sportive, et remplit les cases correspondantes  
        if (!empty($_POST['structure_sportive_nom']) && !empty($_POST['structure_sportive_type'])) {
            $nom = $_POST['structure_sportive_nom'];
            $type = $_POST['structure_sportive_type'];
            $resultat3 = ajoute_structure($connexion, $nom, $type);

            //S'il a remplit la case année,  le remplissage de la table se_déroule_dans prend la nouvelle année aussi
            if (!empty($_POST['annee'])) {
                $annee_nouvelle = $_POST['annee'];
                $resultat4 = ajoute_sederouledans($connexion, $nom, $type, $annee_nouvelle);
            }
            //sinon c'est rempli avec l'année originale: 
            else {
                $resultat4 = ajoute_sederouledans($connexion, $nom, $type, $_SESSION['edi_annee']);
            }

            //vérifie si les requêtes ont marchés, elles renvoient vrai
            if ($resultat3 == true && $resultat4 == true) {
                echo "Modifiaction de la structure sportive de l'édition avec succès.\n";
            } else
                echo "Erreur avec Structure Sportive, veuillez recommencer.\n";

            //S'il veut modifier  le nom de la structure sportive, et remplit la case correspondante dans le form
        } else if (!empty($_POST['structure_sportive_nom'])) {
            $nom = $_POST['structure_sportive_nom'];
            $resultat3 = ajoute_structure($connexion, $nom, NULL);

            //S'il a remplit la case anné,  le remplissage de la table se_déroule_dans prend la nouvelle année aussi
            if (!empty($_POST['annee'])) {
                $annee_nouvelle = $_POST['annee'];
                $resultat4 = ajoute_sederouledans($connexion, $nom, NULL, $annee_nouvelle);
            }
            //sinon, c'est remplit avec l'année originale: 
            else {
                $resultat4 = ajoute_sederouledans($connexion, $nom, NULL, $_SESSION['edi_annee']);
            }

            //vérifie si les requêtes ont marchés, elles renvoient vrai
            if ($resultat3 == true && $resultat4 == true) {
                echo "Modifiaction du nom de la sturcture de l'édition avec succès.\n";
            } else
                echo "Erreur avec nom structure, veuillez recommencer.\n";

        }
        //S'il veut modifier  le type de la structure sportive, et remplit la case correspondante dans le form : 
        else if (!empty($_POST['structure_sportive_type'])) {
            $type = $_POST['structure_sportive_type'];
            $resultat3 = ajoute_structure($connexion, NULL, $type);

            //S'il a remplit la case année,  le remplissage de la table se_déroule_dans prend la nouvelle année aussi
            if (!empty($_POST['annee'])) {
                $annee_nouvelle = $_POST['annee'];
                $resultat4 = ajoute_sederouledans($connexion, NULL, $type, $annee_nouvelle);
            }
            //sinon c'est remplit avec l'année originale: 
            else {
                $resultat4 = ajoute_sederouledans($connexion, NULL, $type, $_SESSION['edi_annee']);
            }

            //vérifie si les requêtes ont marchés, elles renvoient vrai
            if ($resultat3 == true && $resultat4 == true) {
                echo "Modifiaction du type de structure de l'édition avec succès.\n";
            } else
                echo "Erreur avec le type de structure, veuillez recommencer.\n";

        }
    }


}

//Si l'utilisateur choisis d'ajouter une édition : 
if (isset($_POST['Ajouter'])) {
    $annee = $_POST['annee'];
    $ville = $_POST['ville'];
    $resultat = ajoute_edition($connexion, $annee, $ville);
    //Vérification du résultat de la requête
    if ($resultat == true) {
        echo "Edition ajoutée avec succès.\n";
    } else
        echo "Erreur, veuillez recommencer.\n";
}

//Si l'utilisateur choisi de supprimer une édition 
if (isset($_POST['Supprimer'])) {
    $edition1 = $_POST['edition1'];    
    list($annee, $ville) = explode(", ", $edition1);
    $resultat = supprimer_edit($connexion, $annee, $ville);
    //vérification de la requête
    if ($resultat == true) {
        echo "Suppression de l'édition avec succès.\n";
    } else {
        echo "Erreur, veuillez recommencer.\n";
    }
}

//Si l'utilisateur choisi d'ajouter un couple de danse 
if (isset($_POST['inscrire_adhe'])) {
    $edition_choix = $_POST['editioncompet'];
    $participant1 = $_POST['participant1'];
    $participant2 = $_POST['participant2'];
    $nomgrp = $_POST['nomcpl'];
    // Séparer l'année et la ville de l'édition (car dans le form sous la forme 'annee, ville')
    list($annee, $ville) = explode(", ", $edition_choix);
    list($nom1, $prenom1) = explode(", ", $participant1);
    list($nom2, $prenom2) = explode(", ", $participant2);
    $resultat = ajoute_groupe($connexion, $nom1, $prenom1, $nom2, $prenom2, $nomgrp);
    $participe = ajoute_participe($connexion, $annee, $nom1, $prenom1, $nom2, $prenom2);
    //vérification de la requête
    if ($resultat == true && $participe == true)
        echo "Ajout du groupe avec succès";
}

//Si l'utilisateur choisi de modifier le rang final d'un groupe : 

//Le choix de l'identifiant du groupe
if (isset($_POST['valideridgd'])) {
    global $idgd;
    $idgd = intval($_POST['idgd']);
    $_SESSION['idgd'] = intval($_POST['idgd']);
    $editionR = liste_editiongrp($connexion, $idgd);

}

//Modifie le rang du groupe choisi
if (isset($_POST['validerang'])) {
    $edition_choix = $_POST['editioncompeti'];
    $rang = $_POST['rangchoisi'];
    // Séparer l'année et la ville de l'édition
    list($annee, $ville) = explode(", ", $edition_choix);
    $resultatR = modifier_rang($connexion, $rang, $annee);
    //vérification de la requête
    if ($resultatR == true) {
        echo "Le rang a été affecté avec succès.\n";
    } else {
        echo "Erreur, veuillez recommencer.\n";
    }
}




?>