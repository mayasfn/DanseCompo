<!-- SOUFAN Maya MEJRI Sarra -->
<div class=compétitionvip>

    <h1> Compétition VIP </h1>
    <br>
    <!-- Une fois que l'utilisateur choisi ses paramètres pour la liste de danseurs, 
    l'affichage de la liste générée : -->
    <?php if ($_SESSION['listedanseurs']) {
        ?>

        <h3> Liste de danseurs invités générée : </h3>

        <!-- La liste des danseurs apparait sous forme de tableau pour rendre plus clair -->
        <table class="tableau">
            <thead>
                <tr>

                    <?php
                    global $choix;

                    //Si l'utilisateur choisit les deux paramètes, on affiche les colonnes du tableau correspondant : 
                    if ($_SESSION['choix'] == 2) { ?>
                    <tr>
                        <th>Nom</th>
                        <th>Compétitions</th>
                        <th>École de Danse</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <?php
                //Affichage des données retournées par la requête
                foreach ($_SESSION['list'] as $ligne) {
                    echo '<tr>';
                    echo '<td>' . $ligne['prenom'] . ' ' . $ligne['nom'] . '</td>';
                    echo '<td>' . $ligne['competitions'] . '</td>';
                    echo '<td>' . $ligne['nomecole'] . '</td>';
                    echo '</tr>';
                }
                        //Si il choisit seulement le paramètre de la taille de l'école, on affiche les colonnes correspondantes :  
                    } else if ($_SESSION['choix'] == 'ecole') { ?>
                    <tr>
                        <th>Nom</th>
                        <th>École de Danse</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <?php
                    //Affichage des données retournées par la requête
                    foreach ($_SESSION['list'] as $ligne) {
                        echo '<tr>';
                        echo '<td>' . $ligne['prenom'] . ' ' . $ligne['nom'] . '</td>';
                        echo '<td>' . $ligne['nomecole'] . '</td>';
                        echo '</tr>';
                    }
                    } else {
                        //Si il choisit seulement le paramètre du palmarès, 
                        //on affiche les colonnes correspondantes :  ?>

                    <tr>
                        <th>Nom</th>
                        <th>Compétitions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <?php
                    //Affichage des données retournées par la requête
                    foreach ($_SESSION['list'] as $ligne) {
                        echo '<tr>';
                        echo '<td>' . $ligne['prenom'] . ' ' . $ligne['nom'] . '</td>';
                        echo '<td>' . $ligne['competitions'] . '</td>';
                        echo '</tr>';
                    }
                    }
                    ?>
            </tbody>
        </table>
        <br> <br>

        <form action="index.php?page=compétitionvip" method="post">

            <input type="submit" name="retourd" value="Générez une liste différente">

        </form>
        <?php
    } else { ?>
        <!-- Sur la page principale, le form avec les filtres possible pour la liste de danseurs -->

        <h3>Générez la liste des danseurs invités </h3>
        Choississez les paramètres d'importance :
        <br> <br>
        <form action=" " method="post">
            <label for="nb"> Nombre maximal des invités voulu: </label>
            <input type="number" name="nb" required>
            <br> <br>
            <label for="taille">Taille minimale des adhérants de l'Ecole voulu: </label>
            <input type="number" name="taille">
            <br> <br>

            <input type="checkbox" name="inclure" id="inclure">
            <label for="inclure">Inclure le palmarès de danseurs</label>
            <br><br>
            <input type="submit" name="validerdanseurs" value="Valider">

        </form>

        <!-- Une fois que l'utilisateur choisi ses paramètres pour la liste d'organisateurs, 
    l'affichage de la liste générée : -->
    <?php }
    if ($_SESSION['orgacom']) { ?>

        <h3> Liste des comités organisateurs générée : </h3>

        <table class="tableau">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nombre d’organisation d’éditions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['listo'] as $com) {
                    echo '<tr>';
                    echo '<td>' . $com['nom'] . '</td>';
                    echo '<td>' . $com['nb_orga'] . '</td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>

        <br> <br>
        <h3> Lieu généré : </h3>

        <?php echo $_SESSION['ville']; ?>

        <br>
        <form action="index.php?page=compétitionvip" method="post">

            <input type="submit" name="retourc" value="Générez une liste différente">

        </form>
    <?php } else { ?>
        <!-- Sur la page principale, le form avec les filtres possible pour la liste d'organisateurs -->

        <h3>Générez la liste des comités organisateurs</h3>
        <h4>Le lieu possible de la compétition s'affichera dès que vous choississez vos</h4>
        <br>
        <br>
        <form action=" " method="post">
            <label for="nbm"> Nombre maximal de comités organisateurs voulu: </label>
            <input type="number" name="nbm" required>
            <br> <br>
            <label for="nbeditions">Nombre d’organisation d’éditions minimales par le ou les comités voulu: </label>
            <input type="number" name="nbeditions">
            <br>
            <input type="submit" name="validerorga" value="Valider">

        </form>
    <?php } ?>

</div>