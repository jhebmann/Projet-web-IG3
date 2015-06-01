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
		<title>Other Items</title>
	</head>
	<body>
		<h1>Other Items</h1>
		<?php
			include('menus/menuitems.php');
			include ('menus/menu.php');
			if ($_GET["type"]=="consumables" || $_GET["type"]=="keys" || $_GET["type"]=="embers" || $_GET["type"]=="ores" || $_GET["type"]=="bonfireitems" || $_GET["type"]=="ammos" || $_GET["type"]=="multiplayeritems")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
				if ($type=="BONFIREITEM")
					$type="BONFIRE ITEM";
				if ($type=="MULTIPLAYERITEM")
					$type="MULTIPLAYER ITEM";
			}
			else
			{
				$type="*";
			}
			if ($type!="*")
			{
				echo "<h2>".$type."S</h2>";
			}
			include('menus/menuotheritems.php');
			if ($type!="*")
				$sql = "SELECT * FROM ITEM WHERE TYPE=\"".$type."\" ORDER BY NAME;";
			else
				$sql = "SELECT * FROM ITEM WHERE TYPE=\"CONSUMABLE\" OR TYPE=\"KEY\" OR TYPE=\"EMBER\" OR TYPE=\"ORE\" OR TYPE=\"BONFIRE ITEM\" OR TYPE=\"AMMO\" OR TYPE=\"MULTIPLAYER ITEM\" ORDER BY TYPE, NAME;";
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Otheritems.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>