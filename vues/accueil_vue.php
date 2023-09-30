<!-- SOUFAN Maya MEJRI Sarra
  Page d'accueil du website avec des informations générales -->
<div class=accueil>
  <div class="box">
    <form method="post" action="#">
      <h2>Choisissez votre mode d'identification :</h2>
      <br>
      <button type="submit" name="Ecole">Identification Ecole</button>
      <br> <br> <br>
      <button type="submit" name="Fédération">Identification Fédération</button>
    </form>
  </div>
  <div class="statistique">
    <h3> Bienvenue à DanseCompo! </h3>
    Grâce à DanseCompo, vous pouvez gérer un ensemble d’école de danses
    et de compétitions organisées par des fédérations.
    <br>
    <h3>Nos statistiques:</h3>
    <?php
    //Affichage de statistiques générales
    echo "On a : " . $nbrs['nbFed'] . "  Fédération(s) <br> <br>  \n";
    echo "On a : " . $nbrs['nbCR'] . "  Comités régionaux <br> <br>  \n";
    echo "On a : " . $nbrs['nbCD'] . " " . "Comités départementaux <br> <br> \n";
    echo "On a : " . $nb_ecole['nombre_ecoles'] . " écoles par code de département français <br> <br>\n";
    ?>
    La liste des comités régionaux de la Fédération Française de Danse:
    <?php
    //Affichage si l'utilisateur le veut afficher : (en cliquant sur le bouton)
    if (isset($_POST['Afficher'])) {
      while ($ligne = mysqli_fetch_assoc($comite_reg)) {
        echo $ligne['nom'] . "<br> <br> \n";
      }
    } else {
      ?>
      <form method="post" action="#">
        <button type="submit" name="Afficher">Afficher la liste des comités </button>
      </form>
      <?php

    }
    ?>
    Le top cinq des écoles françaises qui ont eu le plus grand nombre d’adhérents en 2022:
    <?php
    //Affichage si l'utilisateur le veut afficher : (en cliquant sur le bouton)
    if (isset($_POST['AfficherEcole'])) {
      while ($lignes = mysqli_fetch_assoc($top_ecole)) {
        echo $lignes['nom'] . " " . "à " . $lignes['ville'] . "<br> <br> \n";
      }
    } else {
      ?>
      <form method="post" action="#">
        <button type="submit" name="AfficherEcole">Afficher le nom de ces écoles </button>
      </form>
      <?php
    }
    ?>
  </div>
</div>