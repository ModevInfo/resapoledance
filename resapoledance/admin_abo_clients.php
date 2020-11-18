<?php require('includes/connect.php'); ?>
<?php

//Suppresion de la ligne concours
//echo "Ligne ‡ supprimer " . $_POST["id_suppr"];
if(empty($_POST["id_suppr"])) { 
}
else
{
	mysqli_query($link,"DELETE FROM ABO_CLIENT WHERE ID_CLIENT = ". $_POST["id_suppr"] . "") or die("suppression impossible");
	$id_suppr="";
 } 
if($_POST["action"]=='METTRE A JOUR')
 {
  //echo "UPDATE ABO_CLIENT SET RESTANT= ". $_POST["nbcoursmodif"] . " WHERE ID_CLIENT = ". $_POST["idclient"] . " AND ID_ABO = ". $_POST["sel_abo"] . " ";
	mysqli_query($link,"UPDATE ABO_CLIENT SET RESTANT= ". $_POST["nbcoursmodif"] . ", EXPIRATION = '" . $_POST["expiration"] . "', ID_ABO = ". $_POST["sel_abo"] . " WHERE ID_CLIENT = ". $_POST["idclient"] . " ")  or die("mise ‡ jour impossible");
 }
 
if($_POST["action"]=='CREER')
{
//echo "Insertion";
	//echo "INSERT INTO ABO_CLIENT(ID_CLIENT, ID_ABO, RESTANT) VALUES (". $_POST["idclient"] . ", ". $_POST["sel_abo"] . ", ". $_POST["nbcours"] . ")";
	mysqli_query($link,"INSERT INTO ABO_CLIENT(ID_CLIENT, ID_ABO, RESTANT, EXPIRATION) VALUES (". $_POST["idclient"] . ", ". $_POST["sel_abo"] . ", ". $_POST["nbcours"] . ", '". $_POST["expiration"] . "')") or die("insertion impossible");
 $nom="";
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
<table border="0" height="0" width="750">
  <tbody>
    <tr>
      <td rowspan="2" align="center" width="700">
      <div align="center">
      <p class="Style1"><font size="4">CLIENTS (QUI N'ONT PAS ENCORE D'ABONNEMENT)</font></p>

	  <table width="90%"  border="2" bordercolor="#0000FF">
        <tr bgcolor="#CCCCCC">
          <td width="5%"><div align="center" class="libelle_ligne">ID</div></td>
		  <td width="20%"><div align="center" class="libelle_ligne">NOM</div></td>
		  <td width="20%"><div align="center" class="libelle_ligne">PRENOM</div></td>
		  <td width="20%"><div align="center" class="libelle_ligne"></div></td>
        </tr>
		<?php 
		$result=mysqli_query($link,"SELECT ID, NOM, PRENOM, VILLE FROM CLIENTS WHERE ID NOT IN (SELECT ID_CLIENT FROM ABO_CLIENT) ORDER BY NOM ASC");
		//$row  =  mysql_fetch_row($result);
		while ($clients = mysqli_fetch_array($result, MYSQLI_NUM))
		{
		  echo "<tr>";
      echo "<td><div align=center class=textesimple>$clients[0]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[1]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[2]</div></td>";
		  //echo "<td><div align=center class=textesimple>$clients[3]</div></td>";
		  //echo "<td><div align=center><form method=post action=admin_abo_clients.php><input type=hidden name=id_suppr value=$clients[0]><input type=submit name=suppr value=Supprimer></form></div></td>";
		  echo "<td><div align=center><form method=post action=admin_abo_clients.php><input type=hidden name=id_modif value=$clients[0]><input type=hidden name=nom_choix value=$clients[1]><input type=submit name=choix value='CREER'></form></div></td>";
		  echo "</tr>";
		  }
		  ?>
      </table>
<table border="0" height="0" width="750">
  <tbody>
    <tr>
      <td rowspan="2" align="center" width="700">
      <div align="center">
      <p class="Style1"><font size="4">ABONNEMENTS CLIENTS</font></p>

	  <table width="90%"  border="2" bordercolor="#0000FF">
        <tr bgcolor="#CCCCCC">
          <td width="20%"><div align="center" class="libelle_ligne">Nom</div></td>
		  <td width="35%"><div align="center" class="libelle_ligne">Abonnement</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">Restant</div></td>
          <td width="15%"><div align="center" class="libelle_ligne">Expiration</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">Action</div></td>
		  <td width="10%"><div align="center" class="libelle_ligne">Action</div></td>
        </tr>
		<?php 
		$result=mysqli_query($link,"SELECT C.ID, C.NOM, AC.ID_ABO, AC.RESTANT, AC.EXPIRATION, A.LIBELLE, C.PRENOM FROM ABO_CLIENT AC, CLIENTS C, ABONNEMENTS A WHERE AC.ID_CLIENT = C.ID AND AC.ID_ABO = A.ID_ABO ORDER BY NOM ASC");
		while ($clients = mysqli_fetch_array($result, MYSQLI_NUM))
		{
		  echo "<tr>";
      echo "<td><div align=center class=textesimple>$clients[6] $clients[1]</div></td>";
		  echo "<td><div align=center class=textesimple>$clients[5]</div></td>";
      if ($clients[3] < 3)
      {
      echo "<td bgcolor=red><div align=center class=textesimple>$clients[3]</div></td>";
      }
      else
      {
		  echo "<td><div align=center class=textesimple>$clients[3]</div></td>";
                  }
		if ($clients[4] < date('Y-m-d'))
			{
			echo "<td bgcolor=red><div align=center class=textesimple>" . datefr($clients[4]) . "</div></td>";
			}
		else
		{
		  //echo "<td><div align=center class=textesimple>" . datefr($clients[4]) . "</div></td>";
		echo "<td><div align=center class=textesimple>" . datefr($clients[4]) . "</div></td>";
		//echo "<td><div align=center class=textesimple>" . date('Y-m-d') . "</div></td>";	
		}
		  echo "<td><div align=center><form method=post action=admin_abo_clients.php><input type=hidden name=id_suppr value=$clients[0]><input type=submit name=suppr value=S></form></div></td>";
		  echo "<td><div align=center><form method=post action=admin_abo_clients.php><input type=hidden name=id_modif value=$clients[0]><input type=hidden name=nom_choix value=$clients[1]><input type=hidden name=id_abo value=$clients[2]><input type=hidden name=lib_abo value=$clients[5]><input type=hidden name=expiration value=$clients[4]><input type=hidden name=restant value=$clients[3]><input type=submit name=choix value=M></form></div></td>";
		  echo "</tr>";
		  }
		  ?>
      </table>
<br>
<br>

  <form name="form1" method="post" action="admin_abo_clients.php">
        <div align="left"><span class="libelle_ligne">CREATION / MODIFICATION D'ABONNEMENT</span><br><br>
          <table width="83%"  border="1" align="center">
            <tr class="Style6">
              <td class="libelle_ligne">ID Client</td>
              <td><input name="idclient" type="text" size="60" maxlength="100" value=<?php echo $_POST["id_modif"]  ?>></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Nom</td>
              <td><input name="nom" type="text" size="60" maxlength="100" value=<?php echo $_POST["nom_choix"]  ?>></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Abonnement</td>
              <td><div id="contenu">
              <select size='1' name='sel_abo'>
 <?php
    $resultabo=mysqli_query($link,"SELECT ID_ABO, LIBELLE, NB_COURS FROM ABONNEMENTS") or die ("Select libelle");
    while ($abo=mysqli_fetch_array($resultabo, MYSQLI_NUM))
    { 
         if ($abo[0] == $_POST["id_abo"])
         {
         echo "<option value=". $abo[0] ." selected>". $abo[1] ."</option><br>";
         }
         else
         {
	       echo "<option value=$abo[0]>". $abo[1] . "</option><br>";
         }
    }    
   ?>   
   </div></td>
            </tr>
            <tr class="Style6">
              <td class="libelle_ligne">Cours restants</td>
			  <td>
			   <?php  
			   //Si on n'a pas dans le post d'ID abo alors on est en crÈation, donc pas de valeur
    if (empty($_POST["restant"])){
	 echo "<input name=nbcours type=text size=10 maxlength=2>";
	 }
	 else 
	 {
    // $rq="Select NB_COURS from ABONNEMENTS WHERE ID_ABO = ".utf8_encode($abo[0])." ;";
    // $resultabo= mysql_query ($rq) or die ("Erreur requÍte");
    // while ($abo=mysql_fetch_row($resultabo))
    // { 
	 echo "<input name=nbcoursmodif type=text size=60 maxlength=100 value=". $_POST["restant"]  .">";
    // }    
	 }
   ?>   </td>
			 
            </tr>
			
	<tr class="Style6">
              <td class="libelle_ligne">Expiration (AAAA-MM-JJ)</td>
              <td><input name="expiration" type="text" size="10" maxlength="10"  value=<?php echo $_POST["expiration"]  ?>></td>
            </tr>
               <tr class="Style6">
              <td colspan="2"><div align="center">
                <input type="submit" name="action" value="CREER">
		<input type="submit" name="action" value="METTRE A JOUR">
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
