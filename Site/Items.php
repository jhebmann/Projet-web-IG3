<?php
	include('connexion.php');
	if (!empty($_GET['add']) && is_numeric($_GET['add']))
	{
		$sql='UPDATE ITEM SET DROP_AMOUNT=DROP_AMOUNT+1 WHERE ID="'.$_GET['add'].'";';
		$requete = $bdd->query($sql);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
		<script src="sorttable.js"></script>
		<title>Items</title>
	</head>
	<body>
		<h1>Items</h1>
		<?php
			include('menus/menuitems.php');
			include ('menus/menu.php');
			$sql = 'SELECT * FROM ITEM ORDER BY TYPE;';
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Type</th><th>Drop Amount</th></tr>";
			foreach($resultats as $num){
				$Type = strtolower($num['TYPE']);
				if ($Type=="ring")
					$Type="Ring";
				$Type=str_replace(" ","",$Type);
				if (substr($Type,-1)=="y" && $Type!="key"){
					$Type=substr($Type,0,strlen($Type)-1);
					$Type=$Type."ie";}
				if (substr($Type,-1)!="s")
					$Type=$Type."s";
				if ($Type=="Rings")
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"".$Type.".php\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."\"><button type=\"button\">ADD</button></a></td></tr>";
				else if ($Type=="helmets" || $Type=="chests" || $Type=="leggings" || $Type=="gauntlets")
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Armors.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
				else if ($Type=="miracles" || $Type=="pyromancies" || $Type=="sorceries")
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Spells.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
				else if ($Type=="consumables" || $Type=="ammos" || $Type=="multiplayeritems" || $Type=="bonfireitems" || $Type=="embers" || $Type=="ores" || $Type=="keys")
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Otheritems.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
				else if ($Type=="smallshields" || $Type=="normalshields" || $Type=="largeshields" ||$Type=="othershields")
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Shields.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
				else
					echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Ordinaryweapons.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."   <a href=\"Items.php?add=".$num['ID']."&type=".$_GET["type"]."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>