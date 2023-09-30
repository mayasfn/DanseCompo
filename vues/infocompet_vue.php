<!-- SOUFAN Maya MEJRI Sarra -->
<div class=infocompet>

    <!-- La page principale a la présentation de la compétition, et des boutons qui représentent différentes fonctionnalités -->
    <?php

    //Si l'utilisateur clique sur modifier une compétition, le form avec les informations à saisir apparait :
    if ($modifiercompet) { ?>

        <br>
        <form action="index.php?page=infocompet" method="post">
            <label for="nom"> Nom: </label>
            <input type="text" name="nom" />
            <br> <br>
            <label for="niveau"> Niveau: </label>
            <input type="text" name="niveau" />
            <br> <br>
            <input type="submit" name="Modifiercompet" value="Modifier">
            <form action="index.php?page=infocompet" method="post">
                <input type="submit" name="retour" value="Retour">
            </form>
        </form>
        <?php

    } else { ?>

        <!-- Affichage du nom et du niveau de la compétition (sur la première page qui apparait quand aucun bouton et cliqué) 
    Si le bouton "modifier une compétition est cliqué alors ça disparait et le form prend ça place-->
        Nom:
        <?php global $compet;
        echo $_SESSION['compet'];
        ?>
        <br> <br>
        Niveau :

        <?php echo $niveauC['niveau'];

        ?>
        <br> <br>

        <form action="index.php?page=infocompet" method="post">
            <input type="submit" name="infocompet" value="Modifier ma compétition">
        </form>

        <br> <br>

        <!-- Si l'utilisateur clique sur modifier une édition -->

    <?php }

    //l'utilisateur choisi quelle édition il veut modifier
    if ($modifieredition) { ?>
        <form method="post" action="#">
            <label for="edition">Sélectionnez l'édition désirée :</label>
            <select id="edition" name="edition">
                <?php
                while ($instances = mysqli_fetch_array($edition)) { ?>
                    <option value="<?php echo $instances['année_e'] . ", " . $instances['ville_organisatrice']; ?> ">
                        <?php echo $instances['année_e'] . ", " . $instances['ville_organisatrice']; ?>
                    </option>
                <?php } ?>
            </select> <br>
            <input type="submit" name="selectedition" value="Valider" />
            <form action="index.php?page=infocompet" method="post">
                <input type="submit" name="retour" value="Retour">
            </form>
        </form>
    <?php }

    // Une fois qu'il choisit une édition, le form pour saisir les modifications apparait
    else if ($modifedition) { ?>
            <form method="post" action="#">
                <label for="annee"> Année: </label>
                <input type="text" name="annee" />
                <br> <br>
                <label for="ville"> Ville: </label>
                <input type="text" name="ville" />
                <br> <br>
                <label for="structure_sportive_nom"> Structure Sportive Nom: </label>
                <input type="text" name="structure_sportive_nom" />
                <br> <br>
                <label for="structure_sportive_type"> Structure Sportive Type: </label>
                <input type="text" name="structure_sportive_type" />
                <br> <br>
                <input type="submit" name="ModifierE" value="Modifier Edition" />
                <form action="index.php?page=infocompet" method="post">
                    <input type="submit" name="retour" value="Retour">
                </form>
            </form>

    <?php }

    //Si l'utilisateur clique sur supprimer une édition, le form avec une liste des éditions apparait
    else if ($supprimeredition) { ?>
               <form method="post" action="#">
            <label for="edition1">Sélectionnez l'édition désirée :</label>
            <select id="edition1" name="edition1">
                <?php
                while ($instances = mysqli_fetch_array($edition1)) { ?>
                    <option value="<?php echo $instances['année_e'] . ", " . $instances['ville_organisatrice']; ?> ">
                        <?php echo $instances['année_e'] . ", " . $instances['ville_organisatrice']; ?>
                    </option>
                <?php } ?>
            </select> <br>
            <input type="submit" name="Supprimer" value="Supprimer" />
                    <form action="index.php?page=infocompet" method="post">
                        <input type="submit" name="retour" value="Retour">
                    </form>
                </form>
    <?php }

    //Si l'utilisateur clique sur ajouter une édition, le form avec les informations à saisir apparait
    else if ($ajouteredition) { ?>
                    <h3> Ajouter une édition </h3>
                    <form method="post" action="#">
                        <label for="annee"> Année: </label>
                        <input type="text" name="annee" />
                        <br> <br>
                        <label for="ville"> Ville: </label>
                        <input type="text" name="ville" />
                        <br> <br>
                        <input type="submit" name="Ajouter" value="Ajouter" />
                        <form action="index.php?page=infocompet" method="post">
                            <input type="submit" name="retour" value="Retour">
                        </form>

                    </form>
        <?php
    }

    //Sinon, sur la page principale, la liste des éditions apparait avec les boutons pour modifier, ajouter, et supprimer une édition
    else { ?>


                    Liste des éditions :
                    <br> <br>

            <?php
            while ($ligne = mysqli_fetch_assoc($editionL)) {
                echo $ligne['année_e'] . ", " . $ligne['ville_organisatrice'] . "<br> <br> \n";
            } ?>

                    <form action="index.php?page=infocompet" method="post">
                        <input type="submit" name="modifie_edition" value="Modifier une édition">
                        <form action="index.php?page=infocompet" method="post">
                            <input type="submit" name="ajouteredition" value="Ajouter une édition">
                            <form action="index.php?page=infocompet" method="post">
                                <input type="submit" name="supprime_edition" value="Supprimer une édition">
                            </form>
                        </form>
                    </form>


                    <br>
    <?php }
    //Si l'utilisateur clique sur inscire un couple, le formulaire avec les informations à saisir apparait : 
    if ($inscrire) { ?>

        <h3> Inscrire un couple </h3>
        Veuillez remplir ce formulaire avec les bonnes informations.
        <br> <br>
        <form method="post" action="#">

            <label for="nomcpl"> Nom du couple: </label>
            <input type="text" name="nomcpl" />
            <br> <br>

            <label for="participant1"> Choississez le premier participant :</label>
            <select id="participant1" name="participant1">
                <?php
                while ($instances1 = mysqli_fetch_array($adherant1)) { ?>
                    <option value="<?php echo $instances1['nom'] . ", " . $instances1['prenom']; ?> ">
                        <?php echo $instances1['nom'] . ", " . $instances1['prenom']; ?>
                    </option>
                <?php } ?>
            </select> <br> <br>

            <label for="participant2"> Choississez le deuxieme participant:</label>
            <select id="participant2" name="participant2">
                <?php
                while ($instances2 = mysqli_fetch_array($adherant2)) { ?>
                    <option value="<?php echo $instances2['nom'] . ", " . $instances2['prenom']; ?> ">
                        <?php echo $instances2['nom'] . ", " . $instances2['prenom']; ?>
                    </option>
                <?php } ?>
            </select> <br> <br>

            <label for="editioncompet"> Choississez l'édition de la compétition: </label>
            <select id="editioncompet" name="editioncompet">
                <?php
                while ($instances3 = mysqli_fetch_array($editionC)) { ?>
                    <option value="<?php echo $instances3['année_e'] . ", " . $instances3['ville_organisatrice']; ?> ">
                        <?php echo $instances3['année_e'] . ", " . $instances3['ville_organisatrice']; ?>
                    </option>
                <?php } ?>
            </select> <br> <br>

            <input type="submit" name="inscrire_adhe" value="Inscrire" />
            <form action="index.php?page=infocompet" method="post">
                <input type="submit" name="retour" value="Retour">
            </form>
        </form>

    <?php }
    //si l'utilisateur clique sur "affecter un rang à un couple" : 
    else if ($rang) {

        ?>

            <!-- L'utilisateur choisi d'abord l'identifiant du groupe qu'il veut modifier-->
            <h3> Affecter un rang à un couple </h3>
            <form action="#" method="post">
                <label for="idgd"> Choississez l'identifiant du groupe :</label>
                <select id="idgd" name="idgd">
                    <?php
                    while ($instances = mysqli_fetch_array($idGD)) { ?>
                        <option value="<?php echo $instances['idGD']; ?> ">
                        <?php echo $instances['idGD']; ?>
                        </option>
                <?php } ?>
                </select> <br> <br>
                <input type="submit" name="valideridgd" value="Choisir">

            </form>
    <?php }
    //Une fois qu'il choisit l'identifiant d'un groupe, le form avec le rang à saisir apparait
    else if ($idgdchoisie) { ?>

                <h3> Affecter un rang à un couple </h3>
                <form action="" method="post">

                    <label for="editioncompeti"> Choississez l'édition de la compétition: </label>
                    <select id="editioncompeti" name="editioncompeti">
                    <?php
                    while ($instances2 = mysqli_fetch_array($editionR)) { ?>
                            <option value="<?php echo $instances2['année_e'] . ", " . $instances2['ville_organisatrice']; ?> ">
                        <?php echo $instances2['année_e'] . ", " . $instances2['ville_organisatrice']; ?>
                            </option>
                <?php } ?>
                    </select> <br> <br>

                    <label for="rangchoisi"> Insérez le rang voulu: </label>
                    <input type="number" name="rangchoisi">

                    <input type="submit" name="validerang" value="Valider">
                    <form action="index.php?page=infocompet" method="post">
                        <input type="submit" name="retour" value="Retour">
                    </form>
                </form>
    <?php } else {
        //Sinon, sur la page principale il y a les différents boutons pour les fonctionalités
        ?>

                <h3> Gérer les compétiteurs </h3>

                <form action="index.php?page=infocompet" method="post">
                    <input type="submit" name="inscrire" value="Inscrire un couple">
                    <form action="index.php?page=infocompet" method="post">
                        <input type="submit" name="rang" value="Affecter un rang à un couple">
                    </form>
                </form>
    <?php } ?>



</div>