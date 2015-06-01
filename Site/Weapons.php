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
		<title>Weapons</title>
	</head>
	<body>
		<h1>Weapons</h1>
		<?php
			include('menus/menuitems.php');
			include ('menus/menu.php');
			if ($_GET["type"]=="catalysts" || $_GET["type"]=="talismans" || $_GET["type"]=="flames")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
			}
			else
			{
				$type="*";
			}
			if ($type!="*")
			{
				echo "<h2>".$type."S</h2>";
			}
			include('menus/menuweapons.php');
			if ($type!="*")
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID AND TYPE=\"".$type."\" ORDER BY NAME;";
			else
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID ORDER BY TYPE, NAME;";
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Durability</th><th>Weight</th><th>Damages</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['DURABILITY']."</td><td>".$num['WEIGHT']."</td><td>".$num['NORMAL_DAMAGES']."</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Weapons.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>