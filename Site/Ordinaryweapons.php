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
			if ($_GET["type"]=="bows" || $_GET["type"]=="greatbows" || $_GET["type"]=="crossbows")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
				$TYPE="Ranged Weapons";
			}
			else if ($_GET["type"]=="daggers" ||$_GET["type"]=="straightswords" ||$_GET["type"]=="curvedswords" ||$_GET["type"]=="katanas" ||$_GET["type"]=="thrustingswords" ||$_GET["type"]=="axes" ||$_GET["type"]=="fistweapons" ||$_GET["type"]=="hammers" ||$_GET["type"]=="spears" ||$_GET["type"]=="halberds" ||$_GET["type"]=="whips" ||$_GET["type"]=="greatswords" ||$_GET["type"]=="ultragreatswords" ||$_GET["type"]=="curvedgreatswords" ||$_GET["type"]=="greataxes" ||$_GET["type"]=="greathammers")
			{
				$type=strtoupper($_GET["type"]);
				$type=substr($type,0,strlen($type)-1);
				$TYPE="Melee Weapons";
			}
			else if ($_GET["type"]=="melee" || $_GET["type"]=="ranged")
			{
				$type=strtoupper($_GET["type"]);
				$TYPE="".ucfirst(strtolower($type))." Weapons";
			}
			else
			{
				$type="*";
			}
			echo "<h2>ORDINARY WEAPONS</h2>";
			include('menus/menuweapons.php');
			echo "<h2>".$TYPE."</h2>";
			include('menus/menuordinaryweapons.php');
			if ($type!="*" && $type!="MELEE" && $type!="RANGED")
			{
				$type2=preg_replace("/ULTRA/","ULTRA ",$type);
				$type2=preg_replace("/CURVED/","CURVED ",$type2);
				$type2=preg_replace("/THRUSTING/","THRUSTING ",$type2);
				$type2=preg_replace("/STRAIGHT/","STRAIGHT ",$type2);
				$type2=preg_replace("/GREATH/","GREAT H",$type2);
				$type2=preg_replace("/GREATH/","GREAT A",$type2);
				$type2=preg_replace("/TW/","T W",$type2);
				$type2=preg_replace("/TB/","T B",$type2);
				echo "<h2>".$type2."S</h2>";
			}
			if ($type!="*")
				include('menus/menu'.strtolower(preg_replace("/ W/","w",$TYPE)).'.php');
			if ($type!="*" && $type!="MELEE" && $type!="RANGED")
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID AND TYPE=\"".$type."\" ORDER BY NAME;";
			else if ($type=="MELEE")
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID AND TYPE IN ('FISTWEAPON','HAMMER','GREATHAMMER','AXE','GREATAXE','DAGGER','THRUSTINGSWORD','STRAIGHTSWORD','GREATSWORD','ULTRAGREATSWORD','KATANA','CURVEDSWORD','CURVEDGREATSWORD','SPEAR','HALBERD','WHIP') ORDER BY TYPE, NAME;";
			else if ($type=="RANGED")
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID AND TYPE IN ('BOW','CROSSBOW','GREATBOW') ORDER BY TYPE, NAME;";
			else
				$sql = "SELECT * FROM WEAPON, ITEM WHERE ID_ITEM=ID AND TYPE IN ('FISTWEAPON','HAMMER','GREATHAMMER','AXE','GREATAXE','DAGGER','THRUSTINGSWORD','STRAIGHTSWORD','GREATSWORD','ULTRAGREATSWORD','KATANA','CURVEDSWORD','CURVEDGREATSWORD','SPEAR','HALBERD','BOW','CROSSBOW','GREATBOW','WHIP') ORDER BY TYPE, NAME;";
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Durability</th><th>Weight</th><th>Damages</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr><td>".$num['NAME']."</td><td>".$num['DURABILITY']."</td><td>".$num['WEIGHT']."</td><td>".$num['NORMAL_DAMAGES']."</td><td>".$num['TYPE']."</td><td>".$num['DROP_AMOUNT']."   <a href=\"Ordinaryweapons.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>