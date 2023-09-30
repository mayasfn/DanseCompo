<!-- SOUFAN Maya MEJRI Sarra
    Page gère l'affichage des informations de la fédération -->
<div class=tableaudebord>

    <h2> Bienvenue à la page de la
        <?php
        echo $info['nom'] . "\n " ?>
    </h2>

    <p class=tableaudebordf_description>

    <h3> Sigle :</h3>
    <?php echo $info['sigle']; ?>
    <h3>Niveau de l'instance :</h3> nationale
    <h3> Adresse: </h3>
    <?php
    echo $adresseF['num_voie'] . " " . $adresseF['rue'] . ", " . $adresseF['cp'] . " " . $adresseF['ville'];
    ?>
    <h3> Nombre de comités:</h3>
    <?php echo $nbCom['nbComite']; ?>

    <h3> Nombre de membres:</h3>

    <?php
    echo $nbmembres['nbmembres']; ?>

    <h3>Nombre d'adhérants ayant participé à une compétition:</h3>
    <?php
    echo $nbadherant['nbparticipe'];
    ?>

    <h3>Liste des compétitions : </h3>
    <table class="tableau">
        <thead>
            <tr>
                <th>Code</th>
                <th>Libellé</th>
                <th>Niveau</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($ligne = mysqli_fetch_assoc($competitionF)) {
                echo "<tr>";
                echo "<td>" . $ligne['code_c'] . "</td>";
                echo "<td>" . $ligne['libellé'] . "</td>";
                echo "<td>" . $ligne['niveau'] . "</td>";
                echo "</tr>";
            } ?>
        </tbody>
    </table>
    </p>
</div>