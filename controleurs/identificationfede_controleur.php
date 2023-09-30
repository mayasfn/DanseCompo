<!-- SOUFAN Maya MEJRI Sarra -->
<?php

$resultats = get_federation($connexion);

//Quand l'utilisateur choisi sa fédération, le nom est sauvegardé dans une variable globale
if (isset($_POST['Valider'])) {
    global $fede;
    $fede = $_POST['federation'];
    $_SESSION['fede'] = $_POST['federation'];
    header("Location: index.php?page=tableaudebordf");
    exit();
}

?>