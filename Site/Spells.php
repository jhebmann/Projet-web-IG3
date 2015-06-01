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
		<title>Spells</title>
	</head>
	<body>
		<h1>Spells</h1>
		<?php
			include('menus/menuitems.php');
			include ('menus/menu.php');
			if ($_GET["type"]=="miracles" || $_GET["type"]=="sorceries" || $_GET["type"]=="pyromancies")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
				if ($type=="SORCERIE" || $type=="PYROMANCIE")
				{
					$type=substr($type,0,strlen($type)-2);
					$type=$type."Y";
				}
			}
			else
			{
				$type="*";
			}
			if ($type!="*")
			{
				echo "<h2>".strtoupper($_GET["type"])."</h2>";
			}
			include('menus/menuspells.php');
			if ($type!="*")
				$sql = "SELECT * FROM ITEM WHERE TYPE=\"".$type."\" ORDER BY NAME;";
			else
				$sql = "SELECT * FROM ITEM WHERE TYPE=\"MIRACLE\" OR TYPE=\"SORCERY\" OR TYPE=\"PYROMANCY\" ORDER BY TYPE, NAME;";
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Spells.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>