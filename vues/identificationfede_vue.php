<!-- SOUFAN Maya MEJRI Sarra
    Page qui gère l'identification d'une fédération -->
<div class=identification>
    <h2>Identification Fédération</h2>
    <form method="post" action="#">
        <label for="federation">Sélectionnez votre nom :</label>
        <select id="federation" name="federation">


            <?php
            //Donne une liste déroulante avec tous les noms de fédérations
            while ($instances = mysqli_fetch_array($resultats)) { ?>
                <option value="<?php echo $instances['nom']; ?> ">
                    <?php echo $instances['nom']; ?>
                </option>
            <?php }
            ?>
        </select> <br>

        <input type="submit" name="Valider" value="Valider" />
    </form>
</div>