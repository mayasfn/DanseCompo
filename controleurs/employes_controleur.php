<!-- SOUFAN Maya MEJRI Sarra -->
<?php
$resultat = liste_employes($connexion);
//l'utilisateur choisit parmi une liste déroulante de noms d'employés et séléctionne un en cliquant sur valider.
if (isset($_POST['Valider'])) {
    $employe = $_POST['employe'];
    list($nom, $prenom) = explode(" ", $employe);
    global $employe_prenom, $employe_nom;
    $employe_prenom = $prenom;
    $employe_nom = $nom;
    $_SESSION['employe_prenom'] = $prenom;
    $_SESSION['employe_nom'] = $nom;

    header("Location: index.php?page=emplInfo");
    exit();

}
?>