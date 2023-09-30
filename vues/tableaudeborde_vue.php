<!-- SOUFAN Maya MEJRI Sarra
Page gère l'affichage des informations de l'école -->
<div class=tableaudebord>


    <h3> Bienvenue à la page de l'
        <?php echo $nomE['nom'] . "\n"; ?>
         fondée par
        <?php
        global $fondateur;
        echo $_SESSION['fondateur'] . "\n";
        ?>
    </h3>

    <p class=tableaudeborde_description>
        <br> <br>
        <h4>Adresse:</h4>
        <?php
        echo $adresseE['num_voie'] . " " . $adresseE['rue'] . ", " . $adresseE['cp'] . " " . $adresseE['ville'] . "\n"; ?>

        <br> <br>

        <h4>Liste des employés: </h4>
   
        <?php
        while ($ligne = mysqli_fetch_assoc($employeE)) {
            echo $ligne['prenom'] . " " . $ligne['nom'] . "<br> <br> \n";
        }
        ?>
       <h4> Nombre d'adhérants inscrits pour l'année en cours: </h4>

        <?php
        echo $nbinscritE['nombre_adh'] . "\n"; ?>

        <br> <br>
        <h4>Liste des cours:</h4>
        <br> <br>
        <ul>
        <?php
        while ($cours = mysqli_fetch_assoc($coursE)) {
            echo " <li> " . $cours['libellé'] . " </li> <br>";
        } ?>

        <h4>Nombre d'adhérants ayant participé à une compétition:</h4>

        <?php echo $nbAdheCompE['nbr_adhe_compe'] . "\n ";
        ?>
        </ul>
    </p>
</div>