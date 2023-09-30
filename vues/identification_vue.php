<!-- SOUFAN Maya MEJRI Sarra
Page qui gère l'identification de l'école -->
<div class=identification>
    <h2> Identification</h2>

    <form method="post" action="#">
        <label for="responsable">
            <h4>Sélectionnez votre nom:</h4>
        </label>
        <select id="responsable" name="responsable">

            <?php
            //Donne une liste déroulante avec tous les noms de fondateurs de l'école
            $resultats = get_responsable($connexion);
            while ($instances = mysqli_fetch_array($resultats)) { ?>
                <option value="<?php echo $instances['fondé_par']; ?> ">
                    <?php echo $instances['fondé_par']; ?>
                </option>
            <?php }
            ?>
        </select> <br>

        <input type="submit" name="Valider" value="Valider" />
    </form>
</div>