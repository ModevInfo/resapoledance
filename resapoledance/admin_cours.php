<?php require('includes/connect.php'); ?>
<?php

//Suppresion de la ligne concours
//echo "Ligne à supprimer " . $_POST["id_suppr"];
if(empty($_POST["id_suppr"])) { 
}
else
{
	mysqli_query($link,"DELETE FROM COURS WHERE ID_COURS = ". $_POST["id_suppr"] . "") or die("suppression impossible");
	$id_suppr="";
 } if($_POST["action"] == 'COMPLET'){	mysqli_query($link,"UPDATE COURS SET COMPLET = 1 WHERE ID_COURS =  ". $_POST["id_complet"] . " ") or die("mise à jour impossible");}if($_POST["action"] == 'ANNULER_COMPLET'){	mysqli_query($link,"UPDATE COURS SET COMPLET = 0 WHERE ID_COURS =  ". $_POST["id_complet"] . " ") or die("mise à jour impossible");} 
if(empty($_POST["date"])) { 
}
else
{
	mysqli_query($link,"INSERT INTO COURS(LIEU, ID_COURS, DESCRIPTION, PROF, DATE, HEURE_DEBUT, HEURE_FIN, NIVEAU, UNITE_TEMPS, NB_MAX_PART, NON_ANNULABLE, NBCOURS_ABO) VALUES ('". $_POST["lieu"] . "','". $_POST["idcours"] . "', '". $_POST["description"] . "', '". $_POST["prof"] . "', '". $_POST["date"] . "', '". $_POST["heure_debut"] . "', '". $_POST["heure_fin"] . "', '". $_POST["niveau"] . "', '". $_POST["ut"] . "', ". $_POST["nbmax"] . ", '" . $_POST["nonannul"] . "', ". $_POST["nbcours"] . " )") or die("creation impossible");
 //$verif = 0;
  } 
  function datefr($date) { 
$split = explode("-",$date); 
$annee = $split[0]; 
$mois = $split[1]; 
$jour = $split[2]; 
return "$jour"."-"."$mois"."-"."$annee"; 
} 

?>
<?php require('includes/struct1.php'); ?>
<div align="center">
<table border="0" height="0" width="900">
  <tbody>
    <tr>
      <td rowspan="2" align="center" width="800">
      <div align="center">
      <p class="titre">.:: LISTE DES COURS ::.</p>
	  <table width="90%"  border="2" bordercolor="#0000FF">
      <tr bgcolor="#CCCCCC">
  		  <td width="5%"><div align="center" class="libelle_ligne">LIEU</div></td>
        <td width="5%"><div align="center" class="libelle_ligne">ID</div></td>
  		  <td width="15%"><div align="center" class="libelle_ligne">DESCRIPTION</div></td>
  		  <td width="5%"><div align="center" class="libelle_ligne">PROF</div></td>
  		  <td width="10%"><div align="center" class="libelle_ligne">DATE</div></td>
  		  <td width="15%"><div align="center" class="libelle_ligne">HEURE DEBUT</div></td>
        <td width="15%"><div align="center" class="libelle_ligne">HEURE FIN</div></td>
  		  <td width="20%"><div align="center" class="libelle_ligne">NIVEAU</div></td>
  		  <td width="5%"><div align="center" class="libelle_ligne">UT</div></td>		  		  
        <td width="5%"><div align="center" class="libelle_ligne">NB MAX</div></td>
        <td width="5%"><div align="center" class="libelle_ligne">NB COURS ABO</div></td>		  
        <td width="5%"><div align="center" class="libelle_ligne">COMPLET</div></td>		  
        <td width="5%"><div align="center" class="libelle_ligne">ACTION</div></td>
      </tr>
		<?php 

		$result=mysqli_query($link,"SELECT C.ID_COURS, C.DESCRIPTION, C.PROF, C.DATE, C.HEURE_DEBUT, C.HEURE_FIN, C.NIVEAU, C.UNITE_TEMPS, C.NB_MAX_PART, C.COMPLET, C.NON_ANNULABLE, C.NBCOURS_ABO, C.LIEU  FROM COURS C WHERE C.DATE >= '" . date('Y-m-d') ."' ORDER BY C.DATE, C.HEURE_DEBUT ASC");
		//$row  =  mysql_fetch_row($result);
		while ($cours = mysqli_fetch_array($result, MYSQLI_NUM))
		{
		  echo "<tr>";
		  echo "<td><div align=center class=textesimple>$cours[12]</div></td>"; // Ajout lieu des cours (Riom ou Clermont)
      echo "<td><div align=center class=textesimple>$cours[0]</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[1]</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[2]</div></td>";
		  echo "<td><div align=center class=textesimple>" . datefr($cours[3]) . "</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[4]</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[5]</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[6]</div></td>";
		  echo "<td><div align=center class=textesimple>$cours[7]</div></td>";		  		  
      echo "<td><div align=center class=textesimple>$cours[8]</div></td>";
      echo "<td><div align=center class=textesimple>$cours[11]</div></td>";
      $coursnonvide=0;		
      $liencours=mysqli_query($link,"SELECT CC.ID_CLIENT FROM COURS_CLIENTS CC WHERE CC.ID_COURS = $cours[0]");
      while ($nbcourscli = mysqli_fetch_array($liencours, MYSQLI_NUM)) 
        {
          $coursnonvide= $coursnonvide + 1;
        }

    if($cours[9]==1)
      {		  
      echo "<td><div align=center class=textesimple>OUI</div></td>";
      if($coursnonvide>0)
        {
        echo "<td><div align=center><form method=post action=admin_cours.php><input type=hidden name=id_suppr value=$cours[0]><div align=center class=textesimple>NON VIDE</div></form><form method=post action=admin_cours.php><input type=hidden name=id_complet value=$cours[0]><input type=submit name=action value=ANNULER_COMPLET></form></div></td>";		  
        }
        else
        {
        echo "<td><div align=center><form method=post action=admin_cours.php><input type=hidden name=id_suppr value=$cours[0]><input type=submit name=suppr value=X></form><form method=post action=admin_cours.php><input type=hidden name=id_complet value=$cours[0]><input type=submit name=action value=ANNULER_COMPLET></form></div></td>";      
        }
      }
      else
      {		  
      echo "<td><div align=center class=textesimple>NON</div></td>";		  		  
        if($coursnonvide>0)
        {
        echo "<td><div align=center><form method=post action=admin_cours.php><input type=hidden name=id_suppr value=$cours[0]><div align=center class=textesimple>NON VIDE</div></form><form method=post action=admin_cours.php><input type=hidden name=id_complet value=$cours[0]><input type=submit name=action value=COMPLET></form></div></td>";     
        }
        else
        {
        echo "<td><div align=center><form method=post action=admin_cours.php><input type=hidden name=id_suppr value=$cours[0]><input type=submit name=suppr value=X></form><form method=post action=admin_cours.php><input type=hidden name=id_complet value=$cours[0]><input type=submit name=action value=COMPLET></form></div></td>";      
        }
      }		  
      echo "<td><div align=center class=textesimple>$cours[10]</div></td>";
		  echo "</tr>";
		  }
		
		  ?>
      </table>

<br>
<br>
  <form name="form1" method="post" action="admin_cours.php">
        <div align="left"><span class="libelle_ligne">NOUVEAU COURS</span><br><br>
          <table width="83%"  border="1" align="center">
		    <tr class="Style6">
              <td class="libelle_ligne">LIEU</td>
              <td><select name="lieu">
					<option value="GOMOT RDC">GOMOT RDC</option>
          <option value="GOMOT UP">GOMOT UP</option>
              </select></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">DESCRIPTION</td>
              <td><input name="description" type="text" size="60" maxlength="100"></td>
            </tr>
			<tr class="Style6">
              <td class="libelle_ligne">PROF</td>
              <td><select name="prof">
					<option value="DOROTHEE">DOROTHEE</option>
					<option value="HEVI">HEVI</option>
          <option value="ROXANE">ROXANE</option>
          <option value="DANAE">DANAE</option>
          <option value="GUEST">GUEST</option>
              </select></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">DATE</td>
              <td><input name="date" type="text" size="10" maxlength="10"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">HEURE DEBUT</td>
              <td><input name="heure_debut" type="text" size="5" maxlength="5"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">HEURE FIN</td>
              <td><input name="heure_fin" type="text" size="5" maxlength="5"></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">NIVEAU</td>
              <td><select name="niveau">
		              <option value="TOUS NIVEAUX">TOUS NIVEAUX</option>
		              <option value="INI">INITIATION</option>
	                <option value="DEB">DEBUTANT</option>
                  <option value="INT">INTER</option>
                  <option value="AVA">AVANCE</option>
              </select></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">UNITE TEMPS</td>
              <td><input name="ut" type="text" size="5" maxlength="5"></td>
            </tr>						            
              <tr class="Style6">              
                 <td class="libelle_ligne">NB MAX PARTICIPANTS</td>              
                    <td><input name="nbmax" type="text" size="2" maxlength="2"></td>            
              </tr>									            
                <tr class="Style6">              
                        <td class="libelle_ligne">NON ANNULABLE (1 = OUI / 0 = NON)</td>              
                               <td><input name="nonannul" type="text" size="1" maxlength="1"></td>            
                </tr>
                <tr class="Style6">              
                        <td class="libelle_ligne">NB COURS ABO</td>              
                               <td><input name="nbcours" type="text" size="2" maxlength="2"></td>            
                </tr>
              
              <td colspan="2"><div align="center">
                <input type="submit" name="Submit" value="Enregistrer">
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
