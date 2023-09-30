<!-- SOUFAN Maya MEJRI Sarra -->
<div class=competition>
    <?php

    //form pour ajouter une compétition : 
    
    if ($ajoutercompet) {
        ?>

        <form method="post" action="#">
            <label for="codec"> Code: </label>
            <input type="text" name="codec" required />
            <br> <br>
            <label for="libellé"> Libellé: </label>
            <input type="text" name="libellé" required />
            <br> <br>
            <label for="niveau"> Niveau: </label>
            <input type="text" name="niveau" require />
            <br> <br>
            <label for="comite">Sélectionnez le comité qui gère la compétition:</label>
            <select id="comite" name="comite" required>

                <?php

                while ($instances = mysqli_fetch_array($nomcom)) { ?>
                    <option value="<?php echo $instances['nom']; ?> ">
                        <?php echo $instances['nom']; ?>
                    </option>
                <?php }
                ?>
            </select> <br>

            <input type="submit" name="ajoute" value="Ajouter" />

        </form>
        <form action="index.php?page=selectcompet" method="post">
            <input type="submit" name="retour" value="Retour">
        </form>

    <?php
        //form pour supprimer un compétition: 
    } else if ($supprimercompet) {
        ?>

            <form method="post" action="#">
                <label for="supprime">Sélectionnez:</label>
                <select id="supprime" name="supprime">

                    <?php

                    while ($instances = mysqli_fetch_array($resultats)) { ?>
                        <option value="<?php echo $instances['libellé']; ?> ">
                        <?php echo $instances['libellé']; ?>
                        </option>
                <?php }
                    ?>
                </select> <br>

                <input type="submit" name="supprimer" value="Supprimer" />
            </form>

            <!-- bouton retour : -->

            <form action="index.php?page=selectcompet" method="post">
                <input type="submit" name="retour" value="Retour">
            </form>


        <?php
        //page de début, séléctionner une compétitoin : 
    
    } else {
        ?>
            <h2>Séléctionnez une compétition</h2>
            <br>
            <form method="post" action="#">
                <label for="competition">Sélectionnez:</label>
                <select id="competition" name="competition">

                    <?php

                    while ($instances = mysqli_fetch_array($resultats)) { ?>
                        <option value="<?php echo $instances['libellé']; ?> ">
                        <?php echo $instances['libellé']; ?>
                        </option>
                <?php }
                    ?>
                </select> <br>

                <input type="submit" name="Valider" value="Valider" />
            </form>

            <br> <br>
            <form action="index.php?page=selectcompet" method="post">
                <input type="submit" name="ajoutercompet" value="Ajouter une compétition">
                <input type="submit" name="supprimecompet" value="Supprimer une compétition">

            </form>
    <?php } ?>
</div>