<?php
	include('connexion.php');
	if (!empty($_GET['add']) && is_numeric($_GET['add']))
	{
		$sql='UPDATE ITEM SET DROP_AMOUNT=DROP_AMOUNT+1 WHERE ID="'.$_GET['add'].'";';
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
		<title>Rings</title>
	</head>
	<body>
		<h1>Rings</h1>
		<?php
			include('menus/menuitems.php');
			include ('menus/menu.php');
			$sql = 'SELECT * FROM ITEM WHERE TYPE="RING";';
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Rings.php?add=".$num['ID']."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>