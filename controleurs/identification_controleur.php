<!-- SOUFAN Maya MEJRI Sarra -->
<?php

//Quand l'utilisateur fait son choix, le nom du fondateur de l'école est sauvegardé dans une variable globale
$resultats = get_responsable($connexion);
if (isset($_POST['Valider'])) {
    global $fondateur;
    $fondateur = $_POST['responsable'];
    $_SESSION['fondateur'] = $_POST['responsable'];
    header("Location: index.php?page=tableaudeborde");
    exit();
}


?>