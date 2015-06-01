<?php
	include('connexion.php');
	if (!empty($_GET['add']) && is_numeric($_GET['add']))
	{
		$sql='UPDATE LOCATION SET DEATH_AMOUNT=DEATH_AMOUNT+1 WHERE ID="'.$_GET['add'].'";';
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
		<title>Locations</title>
	</head>
	<body>
		<h1>Locations</h1>
		<?php
			include ('menus/menulocations.php');
			include ('menus/menu.php');
			$sql='SELECT * FROM LOCATION_DEATHS WHERE DLC=1';
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Location</th><th>Boss number</th><th>In DLC</th><th>Environemental or PVP Deaths</th><th>Total Deaths</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td id=\"dlc\">".$num['NAME']."</td> <td id=\"dlc\">".$num['BOSSES_NBR']."</td><td id=\"dlc\">Yes</td><td>".$num['DEATH_AMOUNT']."   <a href=\"/DLClocations.php?add=".$num['ID']."\"><button type=\"button\">ADD</button></a></td><td>".$num['TOTAL']."</td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>