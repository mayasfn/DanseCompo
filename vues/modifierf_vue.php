<!-- SOUFAN Maya MEJRI Sarra
Page qui gère la modification d'une fédération 
L'utilisateur peut choisir de modifier n'importe quelle information du form-->
<div class="modifier">
    <h2>Modifier mes informations: </h2>


    <form method="post" action="#">
        <label for="nom"> Nom: </label>
        <input type="text" name="nom" />
        <br> <br>
        Adresse: <br>
        <label for="numvoie"> Numéro de voie: </label>
        <input type="number" name="numvoie" />
        <br> <br>

        <label for="rue"> Rue: </label>
        <input type="text" name="rue" />
        <br> <br>
        <label for="cp"> Code postale: </label>
        <input type="text" name="cp" />
        <br> <br>
        <label for="ville"> Ville: </label>
        <input type="text" name="ville" />
        <br> <br>
        <input type="submit" name="Valider" value="Modifier" />

    </form>

</div>