<!-- SOUFAN Maya MEJRI Sarra -->

<?php

////////////////////////////////////////////////////////////////////////
///////    Gestion de la connxeion   ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
* Initialise la connexion à la base de données courante (spécifiée selon constante 
globale SERVEUR, UTILISATEUR, MOTDEPASSE, BDD)			
*/
function open_connection_DB()
{
	global $connexion;

	$connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
		printf("Échec de la connexion : %s\n", mysqli_connect_error());
		exit();
	}
}

/**
 *  	Ferme la connexion courante
 * */
function close_connection_DB()
{
	global $connexion;

	mysqli_close($connexion);
}

// LES 4 FONCTIONS DE  STATISTIQUES
// cette fonction rentourne le nombre de fédérations, comité regionaux et départementaux de la base 
function get_nb_federations($connexion)
{
	$requete = "SELECT COUNT( DISTINCT F.idF) AS  nbFed,
	COUNT(DISTINCT C1.idCom) AS nbCR ,
			  COUNT(DISTINCT C2.idCom ) AS nbCD 
  FROM p2101522.Fédération F JOIN p2101522.Comité C1 ON F.idF=C1.idF
	  JOIN  p2101522.Comité C2 ON F.idF=C2.idF
  WHERE C1.niveau='reg' AND C2.niveau='dept'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}
// cette fonction retourne Le nombre d’écoles par code de département français
function get_nb_ecole_par_depart($connexion)
{
	$requete = "SELECT
	CASE 
		WHEN adr.cp LIKE '97%' THEN LEFT(adr.cp, 3) 
			ELSE LEFT(adr.cp, 2)
	  END AS code_departement,
	  COUNT(ed.idED) AS nombre_ecoles
	FROM  p2101522.Ecole_de_Danse ed
	   JOIN p2101522.Adresse adr ON ed.idED = adr.idED
	 GROUP BY  code_departement";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

// cette fonction retourne la liste des comités régionaux (libellé) de la Fédération Française de Danse.
function get_comites_reg($connexion)
{
	$requete = "SELECT DISTINCT C.nom
	FROM p2101522.Comité C JOIN  Fédération F ON C.idF=F.idF
	WHERE F. nom = 'Fédération Française de Danse' AND C.niveau='reg'
	ORDER BY C.nom DESC";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

// cette fonction retourne le top 5 des écoles (nom et ville) françaises qui ont eu le plus grand nombre d’adhérents en 2022.
function get_top_ecole($connexion)
{
	$requete = "SELECT e.nom, a.ville, COUNT( i.numLicence) AS nombre_adherents
	FROM Ecole_de_Danse e JOIN est_inscrit i
	ON i.idED = e.idED 
	JOIN Adresse a ON e.idED = a.idED
	WHERE i.année = 2022
	GROUP BY e.nom, a.ville
	ORDER BY nombre_adherents DESC
	LIMIT 5";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//donne la liste des fondateurs pour la page d'indentification Ecole
function get_responsable($connexion)
{
	$sql = "SELECT DISTINCT fondé_par FROM Ecole_de_Danse ORDER BY fondé_par ASC";
	$resultat = mysqli_query($connexion, $sql);
	return $resultat;
}


//Donne le nom de l'école
function get_nom_by_fondepar($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT nom FROM Ecole_de_Danse WHERE fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}
//Donne l'adresse de l'ecole
function get_adresse_by_fondepar($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT a.num_voie,a.rue,a.cp,a.ville FROM Adresse a JOIN Ecole_de_Danse e ON a.idED=e.idED WHERE fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}

// Done une liste des employé dans l'école
function get_employe_by_fondepar($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT emp.prenom,emp.nom FROM Ecole_de_Danse e JOIN travaille t ON e.idED=t.idED JOIN Employé emp ON t.idEmp=emp.idEmp WHERE fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Donne la liste des adhérant inscrits dans une école l'année 2022
function get_nbinscrits_by_fondepar_annee($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT COUNT(*) AS nombre_adh FROM Ecole_de_Danse ed JOIN est_inscrit e ON ed.idED=e.idED WHERE e.année='2022' AND fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

//Donne la liste des cours offerts par l'école
function get_liste_cours_by_fondepar($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT DISTINCT C.libellé FROM  Cours C JOIN  délivre d ON C.idC=d.idC JOIN Ecole_de_Danse ed ON ed.idED=d.idED WHERE ed.fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	//$instances=mysqli_fetch_assoc($resultat);
	return $resultat;
}

//Donne le nombre d'adhérants inscrits dans une compétition 
function get_nb_adh_comp_by_fondepar($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT COUNT(*) AS nbr_adhe_compe  FROM Adhérant A JOIN est_inscrit es ON A.numLicence =es.numLicence JOIN Ecole_de_Danse ED  ON es.idED=ED.idED JOIN Groupe_danse gd ON gd.numLicence_1 =A.numLicence WHERE fondé_par='$fonde_par' UNION SELECT COUNT(*) AS nbr_adhe_compe  FROM Adhérant A JOIN est_inscrit es ON A.numLicence =es.numLicence JOIN Ecole_de_Danse ED  ON es.idED=ED.idED JOIN Groupe_danse gd ON gd.numLicence =A.numLicence WHERE fondé_par='$fonde_par' ";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}




// Fonction pour créer une liste déroulante d'employés
function liste_employes($connexion)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$requete = "SELECT emp.prenom, emp.nom FROM Ecole_de_Danse e JOIN travaille t ON e.idED=t.idED JOIN Employé emp ON t.idEmp=emp.idEmp WHERE fondé_par='$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;

}


//fonction pour afficher les informations concernant les employes
function get_info_employe($connexion)
{
	global $fondateur;
	global $employe_prenom;
	global $employe_nom;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$empl_prenom = mysqli_real_escape_string($connexion, $_SESSION['employe_prenom']);
	$empl_nom = mysqli_real_escape_string($connexion, $_SESSION['employe_nom']);
	$requete = "SELECT t.fonction FROM travaille t JOIN Employé em ON em.idEmp= t.idEmp JOIN Ecole_de_Danse ED ON ED.idED=t.idED WHERE fondé_par='$fonde_par' AND em.nom='$empl_nom' AND em.prenom='$empl_prenom' ";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}

//Ajouter la fonction dans la table travaille
function ajoute_fonction($connexion, $fonctionE, $nomE, $prénomE)
{
	global $fondateur;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$prénom = mysqli_real_escape_string($connexion, $prénomE);
	$nom = mysqli_real_escape_string($connexion, $nomE);
	$fonction = mysqli_real_escape_string($connexion, $fonctionE);
	$requete = "INSERT INTO travaille (idED, idEmp, année, fonction)
				SELECT d.idED, e.idEmp, 2022, '$fonction'
				FROM Employé e JOIN Ecole_de_Danse d ON d.idED=idED
				WHERE e.nom = '$nom' AND e.prenom = '$prénom'
				AND d.fondé_par = '$fonde_par'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//Ajouter un employé dans la table des employes
function ajoute_employe($connexion, $prénomE, $nomE)
{

	$prénom = mysqli_real_escape_string($connexion, $prénomE);
	$nom = mysqli_real_escape_string($connexion, $nomE);
	$requete = "INSERT INTO Employé(prenom, nom) VALUES('$prénom','$nom')";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//modifier les valeurs concernant l’employé sélectionné 
function modifier_employe($connexion, $nouv_fonction)
{
	global $fondateur;
	global $employe_prenom;
	global $employe_nom;
	$fonde_par = mysqli_real_escape_string($connexion, $_SESSION['fondateur']);
	$prenomE = mysqli_real_escape_string($connexion, $_SESSION['employe_prenom']);
	$nomE = mysqli_real_escape_string($connexion, $_SESSION['employe_nom']);
	$requete = "UPDATE Employé E, travaille T, Ecole_de_Danse ED SET T.fonction= '$nouv_fonction' WHERE T.idEmp=E.idEmp AND E.prenom ='$prenomE' AND E.nom='$nomE' AND ED.fondé_par='$fonde_par' AND ED.idED=T.idED";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//donne la liste des noms de federations pour la page d'indentification Federation
function get_federation($connexion)
{
	$sql = "SELECT DISTINCT nom FROM Fédération ORDER BY nom ASC";
	$resultat = mysqli_query($connexion, $sql);
	return $resultat;
}

//Donne des infos sur la fédération (nom, sigle)
function get_infofederation($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT nom, sigle FROM Fédération WHERE nom='$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}

//Donne l'adresse d'une fédération
function get_adressefede($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT a.num_voie,a.rue,a.cp,a.ville FROM Adresse a JOIN Fédération f ON a.idF=f.idF WHERE f.nom='$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}

//Donne le nombre de comité d'une fédération
function get_nbcomité($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT  COUNT(*) AS nbComite FROM Comité c JOIN Fédération f ON c.idF = f.idF WHERE f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

//Donne la liste des compétitions
function get_listcompetition($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT DISTINCT c.code_c, c.libellé, c.niveau FROM Compétition c JOIN gère g ON  g.code_c = c.code_c JOIN Comité co ON co.idCom = g.idCom JOIN Fédération f ON f.idF = co.idF WHERE f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;

}

//Donne le nombre d'adhérant qui participe à une compétition
function get_nbadherant_compet($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT COUNT(DISTINCT p.idGD) AS nbparticipe
	FROM participe p
	JOIN Groupe_danse g on g.idGD = p.idGD 
	JOIN Adhérant a1 ON a1.numLicence = g.numLicence 
	JOIN Adhérant a2 ON a2.numLicence = g.numLicence_1
	JOIN est_inscrit i ON i.numLicence = a1.numLicence
	JOIN Ecole_de_Danse e ON e.idED = i.idED 
	JOIN gère ge ON ge.code_c = p.code_c
	JOIN Comité c ON c.idCom = ge.idCom
	JOIN Fédération f on f.idF = e.idF AND c.idF =f.idF
	WHERE f.nom='$nomfede' ";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

//Donne le nombre de membres dans la fédération
function getnb_membresfede($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT COUNT(DISTINCT i.numLicence) + COUNT(DISTINCT t.idEmp) AS nbmembres
	FROM est_inscrit i
	JOIN Ecole_de_Danse e ON e.idED = i.idED 
	JOIN travaille t ON t.idED = e.idED
	JOIN Fédération f on f.idF = e.idF
	WHERE f.nom='$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;

}
//Modifie le nom d'une fédération
function modifier_fede($connexion, $nom)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$nomf = mysqli_real_escape_string($connexion, $nom);
	$requete = "UPDATE Fédération SET nom = '$nomf' WHERE nom = '$nomfede'";
	$_SESSION['fede'] = $nom;
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Modifie le numéro de voie de l'adresse d'une fédération
function modifier_numvoief($connexion, $numvoie)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "UPDATE Adresse a JOIN Fédération f ON f.idF = a.idF  
				SET a.num_voie = '$numvoie'  WHERE f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Modifie la rue de l'adresse d'une fédération
function modifier_ruef($connexion, $rue)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$ruef = mysqli_real_escape_string($connexion, $rue);
	$requete = "UPDATE Adresse a JOIN Fédération f ON f.idF = a.idF  
				SET a.rue = '$ruef'  WHERE f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Modifie le cp d'une fédération
function modifier_cpfede($connexion, $cp)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$cpfede = mysqli_real_escape_string($connexion, $cp);
	$requete = "UPDATE Adresse a JOIN Fédération f ON f.idF = a.idF  
				SET a.cp = '$cpfede'  WHERE f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Modifie la ville d'une fédération
function modifier_villef($connexion, $ville)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$villef = mysqli_real_escape_string($connexion, $ville);
	$requete = "UPDATE Adresse a JOIN Fédération f ON f.idF = a.idF  
				SET a.ville = '$villef'  WHERE f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Ajoute une nouvelle fédération à la table Fédération
function ajoute_fédération($connexion, $nomf, $siglef, $présidentf)
{

	$nom = mysqli_real_escape_string($connexion, $nomf);
	$sigle = mysqli_real_escape_string($connexion, $siglef);
	$président = mysqli_real_escape_string($connexion, $présidentf);

	$requete = "INSERT INTO Fédération(nom, sigle, president) VALUES('$nom','$sigle', '$président')";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Génère une liste des compétitions
function get_competition($connexion)
{

	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT DISTINCT c.libellé 
	FROM Compétition c 
	JOIN gère g ON g.code_c = c.code_c
	JOIN Comité co ON co.idCom = g.idCom
	JOIN Fédération f on f.idF = co.idF
	WHERE f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Retourne le niveau d'une compétition
function get_nivcompet($connexion)
{

	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$requete = "SELECT DISTINCT c.niveau 
	FROM Compétition c 
	JOIN gère g ON g.code_c = c.code_c
	JOIN Comité co ON co.idCom = g.idCom
	JOIN Fédération f on f.idF = co.idF
	WHERE f.nom = '$nomfede' AND c.libellé = '$libellé'";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

//Génère la liste des éditions d'une compétition
function liste_edition($connexion)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$requete = "SELECT DISTINCT e.année_e, e.ville_organisatrice
		FROM Edition e
		JOIN Compétition c
		ON c.code_c = e.code_c 
		JOIN gère g ON g.code_c = c.code_c
		JOIN Comité co ON co.idCom = g.idCom
		JOIN Fédération f on f.idF = co.idF
		WHERE c.libellé = '$libellé' AND f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;

}

//Modifie le libellé d'une compétition
function modifier_libellécompet($connexion, $nom)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$libellénouv = mysqli_real_escape_string($connexion, $nom);
	$requete = "UPDATE Compétition c 
			JOIN gère g ON g.code_c = c.code_c
			JOIN Comité co ON co.idCom = g.idCom
			JOIN Fédération f on f.idF = co.idF  
			SET c.libellé = '$libellénouv'
			WHERE c.libellé = '$libellé' AND f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Modifie le niveau d'une compétition
function modifier_nivcompet($connexion, $niv)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$niveau = mysqli_real_escape_string($connexion, $niv);
	$requete = "UPDATE Compétition c 
			JOIN gère g ON g.code_c = c.code_c
			JOIN Comité co ON co.idCom = g.idCom
			JOIN Fédération f on f.idF = co.idF  
			SET c.niveau = '$niveau'
			WHERE c.libellé = '$libellé' AND f.nom =  '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Ajoute une nouvelle compétition 
function ajouter_competition($connexion, $nom, $code, $niveau)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $nom);
	$codec = mysqli_real_escape_string($connexion, $code);
	$niv = mysqli_real_escape_string($connexion, $niveau);
	$requete = "INSERT INTO Compétition(code_c, libellé, niveau) VALUES('$codec','$libellé', '$niv')";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Ajoute un tuple dans la table génère par rapport à la nouvelle compétition ajoutée
function ajouter_gere($connexion, $code, $comite)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $compet); //CHECK LATER WHY NOT SESSION
	$codec = mysqli_real_escape_string($connexion, $code);
	$com = mysqli_real_escape_string($connexion, $comite);
	$requete = "INSERT INTO gère(idCom, code_c) 
				SELECT DISTINCT c.idCom, '$codec' 
				FROM Comité c 
				JOIN Fédération f ON f.idF = c.idF
				WHERE c.nom = '$com' AND f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;

}

//Génère tous les noms de comités
function get_nomcomite($connexion)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT c.nom
	FROM Comité c 
	JOIN Fédération f ON f.idF = c.idF
	WHERE f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Supprime une compétition de la table gère
function supprime_gere($connexion, $libellé)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libelle = mysqli_real_escape_string($connexion, $libellé);
	$requete = "DELETE g
	FROM gère g
	JOIN Compétition co ON g.code_c = co.code_c
	JOIN Comité c ON c.idCom = g.idCom
	JOIN Fédération f ON f.idF = c.idF
	WHERE co.libellé = '$libelle' AND f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Supprime une compétition
function supprime_compet($connexion, $libellé)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libelle = mysqli_real_escape_string($connexion, $libellé);
	$requete = "	DELETE FROM Compétition 
	WHERE libellé = '$libelle'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Génère les noms et prénoms des adhérants 
function get_adherant($connexion)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT a.nom, a.prenom
	FROM Adhérant a 
	JOIN est_inscrit i ON a.numLicence = i.numLicence
	JOIN Ecole_de_Danse e ON e.idED = i.idED
	JOIN Fédération f ON f.idF = e.idF 
	WHERE f.nom = '$nomfede'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Ajoute un groupe de danse à la table Groupe_danse
function ajoute_groupe($connexion, $nom1, $prenom1, $nom2, $prenom2, $nomgrp)
{
	$participantn1 = mysqli_real_escape_string($connexion, $nom1);
	$participantp1 = mysqli_real_escape_string($connexion, $prenom1);
	$participantn2 = mysqli_real_escape_string($connexion, $nom2);
	$participantp2 = mysqli_real_escape_string($connexion, $prenom2);
	$nomgroupe = mysqli_real_escape_string($connexion, $nomgrp);
	$requete = "INSERT INTO Groupe_danse(nom, genre, numLicence, numLicence_1)
	SELECT '$nomgroupe', null, a.numLicence, a1.numLicence
	FROM Adhérant a
	JOIN Adhérant a1 ON a.numLicence <> a1.numLicence
	WHERE a.nom = '$participantn1' AND a.prenom = '$participantp1' AND a1.nom = '$participantn2' AND a1.prenom = '$participantp2'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Retourne le code de la compétition choisie
function get_codec($connexion)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$requete = "SELECT DISTINCT co.code_c
	FROM Compétition co
    JOIN gère g ON g.code_c = co.code_c
	JOIN Comité c ON c.idCom = g.idCom
	JOIN Fédération f ON f.idF = c.idF
	WHERE co.libellé = '$libellé' AND f.nom = '$nomfede' ";
	$resultat = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_assoc($resultat);
	return $instances;
}

//Ajoute une edition à la compétition
function ajoute_edition($connexion, $annee, $ville)
{
	global $fede, $compet;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$anneeAj = intval($annee);
	$villeAj = mysqli_real_escape_string($connexion, $ville);
	$requete = " INSERT INTO Edition(code_c, année_e,ville_organisatrice) SELECT c.code_c, '$anneeAj', '$villeAj' FROM Compétition c WHERE c.libellé= '$libellé'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Supprimer une édition d'une compétition 
function supprimer_edit($connexion, $annee, $ville)
{
	global $fede, $compet;
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$anneesup = intval($annee);
	$villesup = mysqli_real_escape_string($connexion, $ville);
	$requete = "DELETE FROM Edition WHERE année_e = '$anneesup' AND ville_organisatrice= '$villesup' AND code_c IN (SELECT code_c FROM Compétition WHERE libellé = '$libellé')";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//fonction qui ajoute un tuple dans la table participe
function ajoute_participe($connexion, $annee, $nom1, $prenom1, $nom2, $prenom2)
{
	$participantn1 = mysqli_real_escape_string($connexion, $nom1);
	$participantp1 = mysqli_real_escape_string($connexion, $prenom1);
	$participantn2 = mysqli_real_escape_string($connexion, $nom2);
	$participantp2 = mysqli_real_escape_string($connexion, $prenom2);
	$année = mysqli_real_escape_string($connexion, $annee);
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$requete = "INSERT INTO participe (code_c, année_e, idGD, num_passage, rang_final)
	SELECT '$code_c', '$année', G.idGD, NULL, NULL
	FROM Groupe_danse G
	JOIN Adhérant A ON G.numLicence = A.numLicence
	JOIN Adhérant A1 ON G.numLicence_1 = A1.numLicence
	WHERE A.nom = '$participantn1' AND A.prenom = '$participantp1' 
	AND A1.nom = '$participantn2' AND A1.prenom = '$participantp2'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//fonction qui donne la liste des idGD de la table Groupe_danse
function get_idgd($connexion)
{
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$requete = "SELECT DISTINCT g.idGD
	FROM Groupe_danse g
    JOIN participe p ON p.idGD = g.idGD
	WHERE p.code_c = '$code_c'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Donne la liste des éditions auxquelles participe le groupe passé en paramètre
function liste_editiongrp($connexion, $idgd)
{
	global $fede, $compet;
	$idGD = intval($idgd);
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$requete = "SELECT DISTINCT e.année_e, e.ville_organisatrice
FROM Edition e
JOIN Compétition c ON c.code_c = e.code_c
JOIN participe p ON p.code_c = c.code_c AND p.année_e = e.année_e
WHERE c.code_c = '$code_c' AND p.idGD = '$idGD'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//fonction qui modifie le rang dans la table participe d'un groupe spécifique
function modifier_rang($connexion, $rang, $annee)
{
	global $idgd;
	$idGD = intval($_SESSION['idgd']);
	$rang_final = intval($rang);
	//$idgd = intval($idGD);
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$année = intval($annee);
	$requete = "UPDATE participe SET rang_final = $rang_final
	WHERE code_c = '$code_c'
	AND année_e = '$année'
	AND idGD =	'$idGD'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//on vérifie si ça existe, si ça existe pas on l'ajoute
function verifie_se_deroule_dans($connexion, $annee)
{
	$année = mysqli_real_escape_string($connexion, $annee);
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$requete = "SELECT EXISTS 
	(SELECT * 
	FROM se_déroule_dans 
	WHERE code_c = '$code_c' AND année_e = '$année') AS existe";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//si = 0 alors on affiche pas une liste avec les structures existantes 
function verifie_structure($connexion)
{
	$requete = "SELECT COUNT(*) FROM structure_sportive";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;

}


//fonction qui ajoute une structure sportive
function ajoute_structure($connexion, $nom, $type)
{
	$nomS = mysqli_real_escape_string($connexion, $nom);
	$typeSP = mysqli_real_escape_string($connexion, $type);
	$requete = "INSERT INTO Structure_sportive(nom, typeSP) VALUES('$nomS', '$typeSP')";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//fonction qui ajoute un tuple dans la table se_déroule_dans
function ajoute_sederouledans($connexion, $nom, $type, $annee)
{
	$nomS = mysqli_real_escape_string($connexion, $nom);
	$typeSP = mysqli_real_escape_string($connexion, $type);
	$année = mysqli_real_escape_string($connexion, $annee);
	$code = get_codec($connexion);
	$code_c = mysqli_real_escape_string($connexion, $code['code_c']);
	$requete = "INSERT INTO se_déroule_dans(code_c, année_e, idSP)
	SELECT '$code_c', $année, S.idSP
	FROM Structure_sportive S
	WHERE S.nom = '$nomS' AND S.typeSP = '$typeSP'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//modifier les informations (l'année) d'une édition 

function modifier_annee_edit($connexion, $annee_nouvelle)
{
	global $fede, $compet, $edi_ville, $edi_annee;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$edit_annee = intval($_SESSION['edi_annee']);
	$edit_ville = mysqli_real_escape_string($connexion, $_SESSION['edi_ville']);
	$année = intval($annee_nouvelle);
	$requete = " UPDATE Edition E JOIN Compétition c ON c.code_c = E.code_c 
		JOIN gère g ON g.code_c = c.code_c
		JOIN Comité co ON co.idCom = g.idCom
		JOIN Fédération f on f.idF = co.idF 
		SET E.année_e = $année
		WHERE f.nom =  '$nomfede' AND c.libellé = '$libellé' AND E.année_e = $edit_annee AND E.ville_organisatrice= '$edit_ville'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//modifier les informations (la ville organisatrice) d'une édition 
function modifier_ville_edit($connexion, $nouvelle_ville, $annee)
{
	global $fede, $compet, $edi_ville, $edi_annee;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$libellé = mysqli_real_escape_string($connexion, $_SESSION['compet']);
	$edit_annee = intval($_SESSION['edi_annee']);
	$anneee = intval($annee);
	$edit_ville = mysqli_real_escape_string($connexion, $_SESSION['edi_ville']);
	$nouvelle_ville = mysqli_real_escape_string($connexion, $nouvelle_ville);
	$requete = " UPDATE Edition E JOIN Compétition c ON c.code_c = E.code_c 
	   JOIN gère g ON g.code_c = c.code_c
	   JOIN Comité co ON co.idCom = g.idCom
	   JOIN Fédération f on f.idF = co.idF 
	   SET E.ville_organisatrice = '$nouvelle_ville'
	   WHERE f.nom =  '$nomfede' AND c.libellé = '$libellé' AND E.année_e = '$anneee' AND E.ville_organisatrice= '$edit_ville'";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//Donne une liste de danseurs inscrits à des ecoles avec un nombre minimale d'adhérants par école, 
//la liste est limité par un nb choisi par l'utilisateur
function list_adhe_taille($connexion, $taille, $nb)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT DISTINCT ed.nom AS nomecole, a.nom, a.prenom
	FROM Adhérant a
	JOIN est_inscrit i ON a.numLicence = i.numLicence
	JOIN Ecole_de_Danse ed ON i.idED = ed.idED
	JOIN Fédération f ON f.idF = ed.idF
	WHERE f.nom='$nomfede' AND ed.idED IN (
	  SELECT idED
	  FROM est_inscrit
	  GROUP BY idED
	  HAVING COUNT(DISTINCT numLicence) >= $taille
	)
	LIMIT $nb";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}


//Donne une liste d'adhérant par rapport au palmarès, la taille de l'école des danseurs, et limite la liste à un nb spécifique
function taille_palmares($connexion, $taille, $nb)
{

	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT ed.nom AS nomecole, a.nom, a.prenom, 
		GROUP_CONCAT(DISTINCT CONCAT('<br> ', C.libellé, ' ', E.année_e, ' rang:  ', p.rang_final) ORDER BY E.année_e) AS competitions,
		MIN(p.rang_final) AS min_rang_final
  		FROM Adhérant a
  		JOIN est_inscrit i ON a.numLicence = i.numLicence
  		JOIN Ecole_de_Danse ed ON i.idED = ed.idED
  		JOIN Fédération f ON f.idF = ed.idF
  		JOIN Groupe_danse GD ON GD.numLicence = a.numLicence OR GD.numLicence_1 = a.numLicence
  		JOIN participe p ON p.idGD = GD.idGD
  		JOIN Edition E ON p.code_c = E.code_c AND p.année_e = E.année_e
 		JOIN Compétition C ON p.code_c = C.code_c
  		WHERE p.rang_final <= 3 AND f.nom='Fédération Française de Danse' AND ed.idED IN (
		SELECT idED
		FROM est_inscrit
		GROUP BY idED
		HAVING COUNT(DISTINCT numLicence) >= $taille)
  		GROUP BY ed.nom, a.nom, a.prenom
  		ORDER BY min_rang_final ASC
  		LIMIT $nb";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}

//Donne le noms des comités qui ont organisé un nombre spécifique d'éditions de compétitions 
function nbedition_com($connexion, $nbedi, $nb)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$requete = "SELECT c.nom, COUNT(e.ville_organisatrice) AS nb_orga, a.ville
	FROM Comité c
	JOIN gère g ON c.idCom = g.idCom
	JOIN Adresse a ON a.idCom = c.idCom
	JOIN Edition e ON g.code_c = e.code_c
	JOIN Fédération f ON f.idF = c.idF
	WHERE f.nom = '$nomfede'
	GROUP BY c.idCom, c.nom
	HAVING (COUNT(e.ville_organisatrice) >= $nbedi)
	ORDER BY nb_orga DESC
	LIMIT $nb";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;
}




//Cette fonction affiche les danseurs les mieux classés dans les diffèrentes compétitions récentes 
//la longueur de laliste depend de combien de danseurs l'utilisateur choisit d'inviter.
function liste_top_danseurs($connexion, $nbinvite)
{
	global $fede;
	$nomfede = mysqli_real_escape_string($connexion, $_SESSION['fede']);
	$nbinviteS = intval($nbinvite);
	$requete = "SELECT A.nom, A.prenom, GROUP_CONCAT(DISTINCT CONCAT(' ', C.libellé, ' ', E.année_e, ' rang : ', p.rang_final) ORDER BY E.année_e) AS competitions, MIN(p.rang_final) AS min_rang_final
		FROM Adhérant A
		JOIN Groupe_danse GD ON GD.numLicence = A.numLicence OR GD.numLicence_1 = A.numLicence
		JOIN participe p ON p.idGD = GD.idGD
		JOIN Edition E ON p.code_c = E.code_c AND p.année_e = E.année_e
		JOIN Compétition C ON p.code_c = C.code_c
		JOIN gère g ON g.code_c = C.code_c
		JOIN Comité co ON co.idCom = g.idCom
		JOIN Fédération f on f.idF = co.idF 
		WHERE p.rang_final <= 3 AND f.nom ='$nomfede'AND E.année_e='2022'
		GROUP BY A.nom, A.prenom
		ORDER BY min_rang_final ASC 
		LIMIT $nbinviteS";
	$resultat = mysqli_query($connexion, $requete);
	return $resultat;


}
