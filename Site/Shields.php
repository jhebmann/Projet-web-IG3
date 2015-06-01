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
			if ($_GET["type"]=="smallshields" || $_GET["type"]=="normalshields" || $_GET["type"]=="largeshields" || $_GET["type"]=="othershields")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
			}
			else
			{
				$type="*";
			}
			echo "<h2>SHIELDS</h2>";
			include('menus/menuweapons.php');
			if ($type!="*")
			{
				echo "<h2>".preg_replace("/SHIELD/"," SHIELD",$type)."S</h2>";
			}
			include('menus/menushields.php');
			if ($type!="*")
				$sql = "SELECT * FROM SHIELD, ITEM WHERE ID_ITEM=ID AND TYPE=\"".$type."\" ORDER BY NAME;";
			else
				$sql = "SELECT * FROM SHIELD, ITEM WHERE ID_ITEM=ID AND TYPE LIKE '%SHIELD%' ORDER BY TYPE, NAME;";
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Durability</th><th>Weight</th><th>Physical Reduction</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['DURABILITY']."</td><td>".$num['WEIGHT']."</td><td>".$num['NORMAL_REDUCTION']."%</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Shields.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>