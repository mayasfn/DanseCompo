
INSERT INTO p2101522.Ecole_de_Danse (idED, nom, fondé_par, idF)
SELECT DISTINCT null, d.ecole_nom, d.ecole_fondateur, f.idF FROM donnees_fournies.instances3 d JOIN p2101522.Fédération f
ON f.nom = d.fede_nom ;

INSERT INTO p2101522.Compétition (code_c, libellé, niveau)
SELECT DISTINCT compet_code, compet_libellé, compet_niveau FROM donnees_fournies.instances2 ; 

INSERT INTO p2101522.Fédération (idF, nom, sigle, president)
SELECT DISTINCT null, fede_nom, fede_sigle, fede_dirigeant FROM donnees_fournies.instances2 ; 

INSERT INTO p2101522.Adhérant (numLicence, nom, prenom, date_naissance)
SELECT DISTINCT danseur_numLicence, danseur_nom, danseur_prenom, danseur_date_naissance FROM donnees_fournies.instances4 ; 

INSERT INTO p2101522.Comité (idCom, nom, niveau, idF)
SELECT DISTINCT null,  comite_reg_nom, comite_reg_niveau, f.idf  FROM donnees_fournies.instances1 JOIN p2101522.Fédération f ON f.nom = fede_nom ; 

INSERT INTO p2101522.Comité (idCom, nom, niveau,  idF)
SELECT DISTINCT null, comite_dept_nom, comite_dept_niveau, f.idf  FROM donnees_fournies.instances1 JOIN p2101522.Fédération f ON f.nom = fede_nom 
WHERE comite_reg_code_dept IS NOT NULL ;

INSERT INTO p2101522.Edition(code_c, année_e, ville_organisatrice) 
SELECT DISTINCT c.code_c, edition_année, edition_ville_orga 
FROM donnees_fournies.instances2
JOIN p2101522.Compétition c ON c.code_c = compet_code ;


INSERT INTO p2101522.rattachement(idCom, idCom_1)
SELECT DISTINCT c.idCom, c1.idCom  FROM p2101522.Comité c 
JOIN donnees_fournies.instances1 ON c.nom = comite_reg_nom 
JOIN p2101522.Comité c1 ON c1.nom = comite_dept_nom
WHERE comite_reg_code_dept IS NOT NULL ;

INSERT INTO p2101522.Adresse (idAD, num_voie, rue, cplt_rue, bp, cedex,  cp, pays, ville, idCom,idF,idED, numLicence,idSP)
SELECT DISTINCT null, adr_danseur_numVoie, adr_danseur_rue, null, null, null,  adr_danseur_cp, null, adr_danseur_ville, null, null, null, danseur_numLicence, null FROM donnees_fournies.instances4 ;

INSERT INTO p2101522.Adresse (idAD, num_voie, rue, cplt_rue, bp, cedex,  cp, pays, ville, idCom,idF,idED, numLicence,idSP)
SELECT DISTINCT null, adr_ecole_numVoie, adr_ecole_rue, null, null, null,  adr_ecole_cp, null, adr_ecole_ville, null, null, e.idED, null, null FROM donnees_fournies.instances3 JOIN p2101522.Ecole_de_Danse e ON e.fondé_par = ecole_fondateur ;

INSERT INTO p2101522.Adresse (idAD, num_voie, rue, cplt_rue, bp, cedex,  cp, pays, ville, idCom,idF,idED, numLicence,idSP)
SELECT DISTINCT null, adr_fede_numVoie, adr_fede_rue, null, null, null,  adr_fede_cp, null, adr_fede_ville, null, f.idF, null, null, null FROM donnees_fournies.instances1 JOIN p2101522.Fédération f ON f.nom = fede_nom ;

INSERT INTO p2101522.Adresse (idAD, num_voie, rue, cplt_rue, bp, cedex,  cp, pays, ville, idCom,idF,idED, numLicence,idSP)
SELECT DISTINCT null, adr_comite_reg_numVoie, adr_comite_reg_rue, null, null, null,  adr_comite_reg_cp, null, adr_comite_reg_ville, c.idCom, null, null, null, null FROM donnees_fournies.instances1 JOIN p2101522.Comité c ON c.nom = comite_reg_nom ;

INSERT INTO p2101522.Adresse (idAD, num_voie, rue, cplt_rue, bp, cedex,  cp, pays, ville, idCom,idF,idED, numLicence,idSP)
SELECT DISTINCT null, adr_comite_dept_numVoie, adr_comite_dept_rue, null, null, null,  adr_comite_dept_cp, null, adr_comite_dept_ville, c.idCom, null, null, null, null FROM donnees_fournies.instances1 JOIN p2101522.Comité c ON c.nom = comite_dept_nom
WHERE comite_reg_code_dept IS NOT NULL AND comite_dept_nom!= comite_reg_nom;

INSERT INTO p2101522.Employé(idEmp, prenom,nom)
SELECT DISTINCT null, cours_resp_prénom, cours_resp_nom 
FROM donnees_fournies.instances3 ;

INSERT INTO p2101522.Cours(idC, code,libellé,catégorie_âge)
SELECT DISTINCT null, cours_code,cours_libellé,cours_categorie_age 
FROM donnees_fournies.instances3 ; 

INSERT INTO p2101522.Période(année)
SELECT  DISTINCT   annee_inscription 
FROM  donnees_fournies.instances4 ;

INSERT INTO p2101522.délivre(idED, idC) 
SELECT DISTINCT e.idED, c.idC 
FROM p2101522.Ecole_de_Danse e JOIN donnees_fournies.instances3 ON ecole_fondateur = e.fondé_par
JOIN p2101522.Cours c ON cours_code = c.code  JOIN p2101522.Adresse ad
ON ad.idED = e.idED
WHERE ad.ville = adr_ecole_ville ;

INSERT INTO p2101522.Groupe_danse(idGD, nom, genre, numLicence, numLicence_1)
SELECT  DISTINCT null, null, null, danseur_numLicence1, danseur_numLicence2 FROM 
donnees_fournies.instances2 ;

INSERT INTO p2101522.est_inscrit(idED,numLicence,année,certificat_médical)
SELECT DISTINCT e.idED, a.numLicence, p.année, null FROM p2101522.Ecole_de_Danse e JOIN donnees_fournies.instances4  ON e.nom = ecole_nom JOIN p2101522.Adhérant a
ON danseur_numLicence = a.numLicence JOIN p2101522.Période p ON p.année= annee_inscription JOIN p2101522.Adresse ad
ON ad.idED = e.idED
WHERE ad.ville = adr_ecole_ville ;

INSERT INTO p2101522.est_responsable_de(idEmp, idC)
SELECT DISTINCT e.idEmp, c.idC FROM p2101522.Employé e JOIN donnees_fournies.instances3  ON e.nom =  cours_resp_nom JOIN p2101522.Cours c
ON cours_code = c.code  JOIN donnees_fournies.instances3 d ON e.prenom = d.cours_resp_prénom;

INSERT INTO p2101522.participe(code_c,année_e, idGD, num_passage,rang_final)
SELECT DISTINCT C.code_c,E.année_e,G.idGD,null,d.rang_final
FROM p2101522.Compétition C JOIN donnees_fournies.instances2 d ON C.code_c= d.compet_code JOIN p2101522.Edition E ON E.année_e=d.edition_année JOIN p2101522.Groupe_danse G ON G.numLicence=d.danseur_numLicence1 
WHERE G.numLicence_1=d.danseur_numLicence2 ;

INSERT INTO p2101522.travaille(idED, idEmp, année, fonction)
SELECT DISTINCT e.idED, em.idEmp, année, 'professeur'
FROM p2101522.Ecole_de_Danse e JOIN donnees_fournies.instances3 ON e.fondé_par = ecole_fondateur JOIN p2101522.Employé em ON em.prenom = cours_resp_prénom JOIN  donnees_fournies.instances3  d ON em.nom = d.cours_resp_nom JOIN p2101522.Période p ON p.année = année
WHERE p.année = 2022 ;

INSERT INTO p2101522.type_danse(id_typeD, type) 
SELECT DISTINCT idD, type_danse FROM donnees_fournies.type_danse ;

INSERT INTO p2101522.gère(idCom, code_c) 
SELECT DISTINCT co.idCom, c.code_c
FROM  p2101522.Compétition c
JOIN donnees_fournies.instances2 d ON  d.compet_code = c.code_c
JOIN p2101522.Adresse a ON a.ville = d.edition_ville_orga
JOIN p2101522.Comité co ON  co.idCom = a.idCom ;
