<!-- SOUFAN Maya MEJRI Sarra
Page qui affiche les informations propre à la fédération choisie -->
<div class=mafédération>

    <h3>Nom : </h3>
    <?php
    echo "{$info['nom']}\n ";
    ?>

    <h3>Niveau de l'instance: </h3>nationale

    <h3>Adresse: </h3>

    <?php
    echo $adresseF['num_voie'] . " " . $adresseF['rue'] . ", " . $adresseF['cp'] . " " . $adresseF['ville'] . "<br> <br>\n";
    ?>
</div>