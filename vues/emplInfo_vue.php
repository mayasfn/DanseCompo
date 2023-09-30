<!-- SOUFAN Maya MEJRI Sarra
Page qui gère la modification d'un employé -->

<?php if (!isset($_POST['Modifier'])) { ?>
<form method="post" action="#">
  <label for="nouv_fonction"> nouvelle Fonction </label>
  <input type="text" name="nouv_fonction" required />
  <br> <br>
  <input type="submit" name="Modifier" value="Modifier" />

</form>
<?php }?>
<form method="post" action="index.php?page=employes">
  <button type="submit">Liste des Employés</button>
</form>