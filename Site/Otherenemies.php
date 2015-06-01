<?php
	include('connexion.php');
	if (!empty($_GET['add']) && is_numeric($_GET['add']))
	{
		$sql='UPDATE ENEMY SET DEATH_AMOUNT=DEATH_AMOUNT+1 WHERE ID="'.$_GET['add'].'";';
		$requete = $bdd->query($sql);
		$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
		<script src="sorttable.js"></script>
		<title>Other Enemies</title>
	</head>
	<body>
		<h1>Other Enemies</h1>
		<?php
			include ('menus/menuhor1.php');
			include ('menus/menu.php');
			$sql = 'SELECT E.ID, E.NAME, E.DEATH_AMOUNT, E.LIFE, L.NAME AS LOCALIZATION FROM LOCATION L, ENEMY E, IS_LOCATED WHERE L.ID=ID_LOCATION AND E.ID=ID_ENEMY AND E.BOSS!=1 ORDER BY L.ID, E.ID';
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>HP</th><th>Localization</th><th>Death Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td> <td>".$num['LIFE']."</td><td>".$num['LOCALIZATION']."</td><td>".$num['DEATH_AMOUNT']."   <a href=\"Otherenemies.php?add=".$num['ID']."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>