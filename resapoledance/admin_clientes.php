<?php require('includes/connect.php'); ?>
<?php

//CREATION OU MODIFICATION
if($_POST["action"] == 'Enregistrer')
{
	if  (empty($_POST["idmodif"])) 
    //ID MODIF VIDE > CREATION
	{
	mysqli_query($link,"INSERT INTO CLIENTS(ID_JOOMLA, NOM, PRENOM, ADRESSE, TEL, NIVEAU) VALUES ('". $_POST["idjoomla"] . "','". $_POST["nom"] . "', '". $_POST["prenom"] . "', '". $_POST["adresse"] . "', '". $_POST["tel"] . "', '". $_POST["niveau"] . "'  )") or die("mise ‡ jour impossible");
	}
	else
//ID MODIF NON VIDE > MODIFICATION
	{
	mysqli_query($link,"UPDATE CLIENTS SET NOM = '". $_POST["nom"] . "' ,  PRENOM = '".  $_POST["prenom"] . "', ID_JOOMLA = '". $_POST["idjoomla"] . "', ADRESSE = '". $_POST["adresse"] . "', TEL = '". $_POST["tel"] . "', NIVEAU = '". $_POST["niveau"] . "' WHERE ID =  ". $_POST["idmodif"] . " ") or die("mise ‡ jour impossible");
	}
	
}


if(empty($_POST["id_suppr"])) { 
}
else
{
	//echo "DELETE FROM CLIENTS WHERE ID = ". $_POST["id_suppr"] . "";
	mysqli_query($link,"DELETE FROM CLIENTS WHERE ID = ". $_POST["id_suppr"] . "") or die("suppression impossible");
	$id_suppr="";
 } 
?>
<?php require('includes/struct1.php'); ?>
<div align="center">
<table border="0" height="0" width="0">
  <tbody>
    <tr>
      <td rowspan="2" align="center" width="605">
      <div align="center">
      <p class="Style1">CLIENTS</p>

	  <table width="95%"  border="2" bordercolor="#0000FF">
        <tr bgcolor="#CCCCCC">
          <td width="20%"><div align="center" class="libelle_ligne">Nom</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">Prenom</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">ID JOOMLA</div></td>
		  <td width="20%"><div align="center" class="libelle_ligne">Adresse</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">Tel</div></td>
		  <td width="15%"><div align="center" class="libelle_ligne">Niveau</div></td>
          <td width="5%"><div align="center" class="libelle_ligne">Modification</div></td>
		  <td width="5%"><div align="center" class="libelle_ligne">Inscription</div></td>
		  <td width="5%"><div align="center" class="libelle_ligne">Suppression</div></td>
        </tr>
		<?php
		$result=mysqli_query($link,"SELECT ID, NOM, PRENOM, ID_JOOMLA, ADRESSE, TEL, NIVEAU FROM CLIENTS ORDER BY NOM ASC");
		while ($clients = mysqli_fetch_array($result, MYSQLI_NUM))
		{
		  echo "<tr>";
          echo "<td><div align=center class=textesimple>$clients[1]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[2]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[3]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[4]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[5]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[6]</div></td>";
		  echo "<td><div align=center><form method=post action=admin_clientes.php><input type=hidden name=idclt value=$clients[0]><input type=hidden name=nom value=$clients[1]><input type=hidden name=prenom value=$clients[2]><input type=hidden name=idjoomla value=$clients[3]><input type=hidden name=adresse value=$clients[4]><input type=hidden name=tel value=$clients[5]><input type=hidden name=niveau value=$clients[6]><input type=submit name=action value=M></form></div></td>";
		  echo "<td><div align=center><form method=post action=inscription_cours.php><input type=hidden name=id_ins value=$clients[0]><input type=submit name=action value=I></form></div></td>";
		  echo "<td><div align=center><form method=post action=admin_clientes.php><input type=hidden name=id_suppr value=$clients[0]><input type=submit name=action value=S></form></div></td>";
		  echo "</tr>";
		  }
		  ?>
      </table>
<br>
<br>
  <form name="form1" method="post" action="admin_clientes.php">
        <div align="left"><span class="libelle_ligne">CREATION  / MODIFICATION FICHE CLIENT</span><br><br>
          <table width="83%"  border="1" align="center">
            <tr class="Style6">
              <td class="libelle_ligne">Nom</td>
              <td><input type=hidden name="idmodif" value=<?php echo $_POST["idclt"]  ?>><input name="nom" type="text" size="60" maxlength="100" value=<?php echo $_POST["nom"]  ?>></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Prenom</td>
              <td><input name="prenom" type="text" size="60" maxlength="100" value=<?php echo $_POST["prenom"] ?>></td>
            </tr>
			<tr class="Style6">
              <td class="libelle_ligne">ID Joomla</td>
              <td><input name="idjoomla" type="text" size="60" maxlength="100" value=<?php echo $_POST["idjoomla"]  ?>></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Adresse</td>
              <td><input name="adresse" type="text" size="60" maxlength="100" value=<?php echo $_POST["adresse"]  ?>></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">TÈl</td>
              <td><input name="tel" type="text" size="20" maxlength="10" value=<?php echo $_POST["tel"] ?>></td>
            </tr>

            <!--<tr class="Style6">
              <td class="libelle_ligne">NIVEAU</td>
              <td><select name="niveau">
			

<?php echo $_POST["niveau"]  ?>
		<option value="TOUS NIVEAUX">TOUS NIVEAUX</option>
		<option value="INITIATION">INITIATION</option>
		<option value="DEBUTANT">DEBUTANT</option>
                <option value="INTER">INTERMEDIAIRE</option>
		<option value="AVANCE">AVANCE</option>
              </select></td>
            </tr>-->
	    <tr class="Style6">
              <td class="libelle_ligne">Niveau</td>
              <td><input name="niveau" type="text" size="20" maxlength="10" value=<?php echo $_POST["niveau"]  ?>></td>
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
