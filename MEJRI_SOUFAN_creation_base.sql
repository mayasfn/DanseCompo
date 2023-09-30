--Sarra Mejri p2101522
--Maya Soufan p2102583
--Cette page permet de créer notre base de données, à partir des données fournies.
--on a remplie notre base de données selon les donnees_fournies, 
--si on allait suivre exatement notre schéma E/A qui correpond à l'ennoncé, on n'allait pas pouvoir la remplir 
--alors on a pas exactement suivi à la lettre notre schéma E/A pour pouvoir remplir la base, comme nous l'a conseillé un professeur de TP.


CREATE TABLE Employé(
   idEmp INT AUTO_INCREMENT,
   prenom VARCHAR(80),
   nom VARCHAR(80),
   PRIMARY KEY(idEmp)
);


CREATE TABLE Cours(
   idC INT AUTO_INCREMENT,
   code VARCHAR(80) NOT NULL,
   libellé VARCHAR(80),
   catégorie_âge VARCHAR(80),
   PRIMARY KEY(idC)
);


CREATE TABLE Eveil_à_la_danse(
   idC INT,
   PRIMARY KEY(idC),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);

CREATE TABLE Danse(
   idC INT,
   catégorie VARCHAR(80),
   PRIMARY KEY(idC),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);

CREATE TABLE Zumba(
   idC INT,
   ambiance VARCHAR(80),
   PRIMARY KEY(idC),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);

CREATE TABLE Séance(
   idC INT,
   num INT,
   jour VARCHAR(80),
   crénaux_horaire TIME,
   PRIMARY KEY(idC, num),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);

CREATE TABLE Période(
   année VARCHAR(80),
   PRIMARY KEY(année)
);



CREATE TABLE Compétition(
   code_c VARCHAR(80),
   libellé VARCHAR(80),
   niveau VARCHAR(80),
   PRIMARY KEY(code_c)
);


CREATE TABLE Edition(
   code_c VARCHAR(80),
   année_e INT,
   ville_organisatrice VARCHAR(80),
   PRIMARY KEY(code_c, année_e),
   FOREIGN KEY(code_c) REFERENCES Compétition(code_c)
   ON UPDATE CASCADE
   ON DELETE CASCADE
);



CREATE TABLE type_danse(
   id_typeD INT AUTO_INCREMENT,
   type VARCHAR(150),
   PRIMARY KEY(id_typeD)
);


CREATE TABLE Adhérant(
   numLicence INT AUTO_INCREMENT,
   nom VARCHAR(80),
   prenom VARCHAR(80),
   date_naissance VARCHAR(80),
   PRIMARY KEY(numLicence)
);

CREATE TABLE Fédération(
   idF INT AUTO_INCREMENT,
   nom VARCHAR(80),
   sigle VARCHAR(80),
   president VARCHAR(80),
   PRIMARY KEY(idF)
);

CREATE TABLE Comité(
   idCom INT AUTO_INCREMENT,
   nom VARCHAR(80),
   niveau VARCHAR(80),
   idF INT NOT NULL,
   PRIMARY KEY(idCom),
   FOREIGN KEY(idF) REFERENCES Fédération(idF)
);

CREATE TABLE Structure_sportive(
   idSP INT AUTO_INCREMENT,
   nom VARCHAR(50),
   typeSP VARCHAR(50),
   PRIMARY KEY(idSP)

);

CREATE TABLE Groupe_danse(
   idGD INT AUTO_INCREMENT ,
   nom VARCHAR(80),
   genre VARCHAR(80),
   numLicence INT,
   numLicence_1 INT,
   PRIMARY KEY(idGD),
   FOREIGN KEY(numLicence) REFERENCES Adhérant(numLicence),
   FOREIGN KEY(numLicence_1) REFERENCES Adhérant(numLicence)
);



CREATE TABLE Ecole_de_Danse(
   idED INT AUTO_INCREMENT,
   nom VARCHAR(80),
   fondé_par VARCHAR(80),
   idF INT NOT NULL,
   PRIMARY KEY(idED),
   FOREIGN KEY(idF) REFERENCES Fédération(idF)
);

CREATE TABLE Adresse (
   idAD INT AUTO_INCREMENT,
   num_voie INT,
   rue VARCHAR(80),
   cplt_rue VARCHAR(80),
   bp VARCHAR(80),
   cedex INT,
   cp VARCHAR(80),
   pays VARCHAR(80),
   ville VARCHAR(80),
   idCom INT,
   idF INT,
   idED INT,
   numLicence INT,
   idSP INT,
   PRIMARY KEY(idAD),
   FOREIGN KEY(idCom) REFERENCES Comité(idCom) ON DELETE SET NULL,
   FOREIGN KEY(idF) REFERENCES Fédération(idF) ON DELETE SET NULL,
   FOREIGN KEY(idED) REFERENCES Ecole_de_Danse(idED) ON DELETE SET NULL,
   FOREIGN KEY(numLicence) REFERENCES Adhérant(numLicence) ON DELETE SET NULL,
   FOREIGN KEY(idSP) REFERENCES Structure_sportive(idSP) ON DELETE SET NULL
);

CREATE TABLE Salle(
   idED INT,
   numero VARCHAR(80),
   superficie DOUBLE,
   nom VARCHAR(80),
   PRIMARY KEY(idED, numero),
   FOREIGN KEY(idED) REFERENCES Ecole_de_Danse(idED)
);

CREATE TABLE Espace_danse(
   idED INT,
   numero VARCHAR(80),
   typeAeration VARCHAR(80),
   typechauffage VARCHAR(80),
   PRIMARY KEY(idED, numero),
   FOREIGN KEY(idED, numero) REFERENCES Salle(idED, numero)
);

CREATE TABLE Vestiaires(
   idED INT,
   numero VARCHAR(80),
   mixte BOOLEAN,
   avec_douches BOOLEAN,
   PRIMARY KEY(idED, numero),
   FOREIGN KEY(idED, numero) REFERENCES Salle(idED, numero)
);

CREATE TABLE délivre(
   idED INT,
   idC INT,
   PRIMARY KEY(idED, idC),
   FOREIGN KEY(idED) REFERENCES Ecole_de_Danse(idED),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);


CREATE TABLE est_inscrit(
   idED INT,
   numLicence INT,
   année VARCHAR(80),
   certificat_médical VARCHAR(80),
   PRIMARY KEY(idED, numLicence, année),
   FOREIGN KEY(idED) REFERENCES Ecole_de_Danse(idED),
   FOREIGN KEY(numLicence) REFERENCES Adhérant(numLicence),
   FOREIGN KEY(année) REFERENCES Période(année)
);

CREATE TABLE travaille(
   idED INT,
   idEmp INT,
   année VARCHAR(80) NULL,
   fonction VARCHAR(50),
   PRIMARY KEY(idED, idEmp, année),
   FOREIGN KEY(idED) REFERENCES Ecole_de_Danse(idED),
   FOREIGN KEY(idEmp) REFERENCES Employé(idEmp),
   FOREIGN KEY(année) REFERENCES Période(année)
);

CREATE TABLE a_pour_influence(
   id_typeD INT,
   id_typeD_1 INT,
   PRIMARY KEY(id_typeD, id_typeD_1),
   FOREIGN KEY(id_typeD) REFERENCES type_danse(id_typeD),
   FOREIGN KEY(id_typeD_1) REFERENCES type_danse(id_typeD)
);

CREATE TABLE rattachement(
   idCom INT,
   idCom_1 INT,
   PRIMARY KEY(idCom, idCom_1),
   FOREIGN KEY(idCom) REFERENCES Comité(idCom),
   FOREIGN KEY(idCom_1) REFERENCES Comité(idCom)
);

CREATE TABLE gère(
   idCom INT,
   code_c VARCHAR(80),
   PRIMARY KEY(idCom, code_c),
   FOREIGN KEY(idCom) REFERENCES Comité(idCom),
   FOREIGN KEY(code_c) REFERENCES Compétition(code_c)
);

CREATE TABLE se_déroule_dans(
   code_c VARCHAR(80),
   année_e INT,
   idSP INT,
   PRIMARY KEY(code_c, année_e, idSP),
   FOREIGN KEY(code_c, année_e) REFERENCES Edition(code_c, année_e)
    ON UPDATE CASCADE
ON DELETE CASCADE,
   FOREIGN KEY(idSP) REFERENCES Structure_sportive(idSP)
    ON UPDATE CASCADE
ON DELETE CASCADE

);
CREATE TABLE participe(
code_c VARCHAR(80),
année_e INT,
idGD INT,
num_passage INT,
rang_final INT,
PRIMARY KEY(code_c, année_e, idGD),
FOREIGN KEY(code_c, année_e) REFERENCES Edition(code_c, année_e)
ON UPDATE CASCADE
ON DELETE CASCADE,
FOREIGN KEY(idGD) REFERENCES Groupe_danse(idGD)
ON UPDATE CASCADE
ON DELETE CASCADE
);
CREATE TABLE est_responsable_de(
   idEmp INT,
   idC INT,
   PRIMARY KEY(idEmp, idC),
   FOREIGN KEY(idEmp) REFERENCES Employé(idEmp),
   FOREIGN KEY(idC) REFERENCES Cours(idC)
);

CREATE TABLE a(
   idC INT,
   id_typeD INT,
   PRIMARY KEY(idC, id_typeD),
   FOREIGN KEY(idC) REFERENCES Danse(idC),
   FOREIGN KEY(id_typeD) REFERENCES type_danse(id_typeD)
);


CREATE TABLE inscription(
   idC INT,
   numLicence INT,
   PRIMARY KEY(idC, numLicence),
   FOREIGN KEY(idC) REFERENCES Cours(idC),
   FOREIGN KEY(numLicence) REFERENCES Adhérant(numLicence)
);

CREATE TABLE assiste(
   idC INT,
   num INT,
   numLicence INT,
   PRIMARY KEY(idC, num, numLicence),
   FOREIGN KEY(idC, num) REFERENCES Séance(idC, num),
   FOREIGN KEY(numLicence) REFERENCES Adhérant(numLicence)
);
