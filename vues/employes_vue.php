<!-- SOUFAN Maya MEJRI Sarra 
    Page qui affiche la liste des employés, où l'utilisateur choisit un pour voir ses informations -->
<h2>Liste des employés</h2>
<br> </br>
<form method="post" action="#">
    <label for="employe">Sélectionnez l'employé :</label>
    <select name="employe" id="employe">
        <?php
        while ($instances = mysqli_fetch_array($resultat)) { ?>
            <option value="<?php echo $instances['nom'] . " " . $instances['prenom']; ?> ">
                <?php echo $instances['nom'] . " " . $instances['prenom']; ?>
            </option>

        <?php }
        ?>
    </select> <br>
    <input type="submit" name="Valider" value="Valider" />
</form>