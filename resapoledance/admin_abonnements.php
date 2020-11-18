<?php require('includes/connect.php'); ?>
<?php


if($_POST["action"]=="Supprimer") 
{
	mysqli_query($link,"DELETE FROM ABONNEMENTS WHERE ID_ABO = ". $_POST["id_suppr"] . "") or die("suppression impossible");
	$id_suppr="";
 } 
if($_POST["action"]=="Enregistrer") 
{
	mysqli_query($link,"INSERT INTO ABONNEMENTS(LIBELLE, NB_COURS, TARIF, TARIF_U) VALUES ('". $_POST["libelle"] . "', ". $_POST["nbcours"] . ", ". $_POST["tarif"] . ", ". $_POST["tarifu"] . " )") or die("crÈation impossible");
 } 
$u_id = $_COOKIE["session_user_id"]; 
?>
<?php require('includes/struct1.php'); ?>
<div align="center">
<table border="0" height="0" width="0">
  <tbody>
    <tr>
      <td rowspan="2" align="center" width="605">
      <div align="center">
      <p><font size="4" face="Baumans">ABONNEMENTS <?php echo  $u_id;?></font></p>

	  <table width="95%"  border="2" bordercolor="#0000FF">
        <tr bgcolor="#CCCCCC">
          <td width="5%"><div align="center" class="libelle_ligne">ID</div></td>
		  <td width="30%"><div align="center" class="libelle_ligne">Designation</div></td>
		  <td width="15%"><div align="center" class="libelle_ligne">Nb Cours</div></td>
		  <td width="15%"><div align="center" class="libelle_ligne">Tarif</div></td>
		  <td width="15%"><div align="center" class="libelle_ligne">Tarif U</div></td>
          <td width="10%"><div align="center" class="libelle_ligne">Action</div></td>
        </tr>
		<?php 
		$result=mysqli_query($link,"SELECT ID_ABO, LIBELLE, NB_COURS, TARIF, TARIF_U FROM ABONNEMENTS ORDER BY LIBELLE ASC");
		//$row  =  mysql_fetch_row($result);
		while ($abo = mysqli_fetch_array($result, MYSQLI_NUM))
		{
		  echo "<tr>";
      echo "<td><div align=center class=textesimple>$abo[0]</div></td>";
		  echo "<td><div align=center class=textesimple>$abo[1]</div></td>";
		  echo "<td><div align=center class=textesimple>$abo[2]</div></td>";
		  echo "<td><div align=center class=textesimple>$abo[3]</div></td>";
		  echo "<td><div align=center class=textesimple>$abo[4]</div></td>";
		  echo "<td><div align=center>";
		  echo "<form method=post action=admin_abonnements.php><input type=hidden name=id_suppr value=$abo[0]><input type=submit name=action value=Supprimer></form></div></td>";
		  echo "</tr>";
		  }
		  ?>
      </table>
<br>
<br>
  <form name="form1" method="post" action="admin_abonnements.php">
        <div align="left"><span class="libelle_ligne">CREATION  / MODIFICATION D'UN ABONNEMENT </span><br><br>
          <table width="83%"  border="1" align="center">
            <tr class="Style6">
              <td class="libelle_ligne">Designation</td>
              <td><input name="libelle" type="text" size="60" maxlength="100"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Nb Cours</td>
              <td><input name="nbcours" type="text" size="60" maxlength="100"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Tarif</td>
              <td><input name="tarif" type="text" size="60" maxlength="100"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Tarif Unitaire</td>
              <td><input name="tarifu" type="text" size="20" maxlength="10"></td>
            </tr>
               <tr class="Style6">
              <td colspan="2"><div align="center">
                <input type="submit" name="action" value="Enregistrer">
              </div></td>
              </tr>
          </table>
          </div>
      </form>
      </div>
      </td>
    </tr>
  </tbody>
</table>
</div>
<?php require('includes/structbas.php'); ?>
</body>
</html>
