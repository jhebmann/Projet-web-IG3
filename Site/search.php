<?php
	function anti_injection($data){
		$banlist = array (
        "insert", "select", "update", "delete", "distinct", "having", "truncate",
        "replace", "handler", "like", "procedure", "limit", "order by", "group by", "drop" 
        );
		if (!preg_match("/[^a-zA-Z0-9 ]+/",$data))
		{
			$data=trim(str_replace($banlist,'',strtolower($data)));
		}
		else
		{
			$data="CAR";
		}
		return $data;
	}
	include('connexion.php');
	$search=anti_injection($_POST["search"]);
	if ($search!=NULL && $search!="CAR")
	{
		$sql="SELECT * FROM ITEM WHERE NAME LIKE '%{$search}%' OR TYPE LIKE '%{$search}%';";
		$requete = $bdd->query($sql);
		$resultatsitems = $requete->fetchAll(PDO::FETCH_ASSOC);
		$sql="SELECT * FROM LOCATION WHERE NAME LIKE '%{$search}%';";
		$requete = $bdd->query($sql);
		$resultatslocations = $requete->fetchAll(PDO::FETCH_ASSOC);
		$sql="SELECT DISTINCT E.NAME, E.DEATH_AMOUNT, E.LIFE, E.BOSS, L.NAME AS LOCALIZATION, E.ID FROM LOCATION L, ENEMY E, IS_LOCATED WHERE L.ID=ID_LOCATION AND E.ID=ID_ENEMY AND E.NAME LIKE '%{$search}%' ORDER BY L.ID, E.ID;";
		$requete = $bdd->query($sql);
		$resultatsenemies1 = $requete->fetchAll(PDO::FETCH_ASSOC);
		$sql="SELECT E.ID, D.ID_ENEMY, D.LIFE_SECOND_BOSS, D.LIFE_SUPER_BOSS_1, D.LIFE_SUPER_BOSS_2 FROM DOUBLE_BOSS D, ENEMY E WHERE ID=ID_ENEMY AND NAME LIKE '%{$search}%';";
		$requete = $bdd->query($sql);
		$resultatsenemies2 = $requete->fetchAll(PDO::FETCH_ASSOC);
		$i=0;
	}
?>
<!DOCTYPE html>
<html id="zone">
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
		<script src="sorttable.js"></script>
		<title>Research</title>
	</head>
	<body>
		<h1>Research</h1>
		<?php
			include('menus/menu.php');
			echo "<form method=\"post\" action=\"search.php\" id=\"center\">";
			echo "Enter term to research<br/><input type=\"text\" id=\"search\" name=\"search\" placeholder=\"Type here\">";
			echo "<input type=\"submit\" value=\"Search\"></form>";
			if(!empty($_POST["search"]) && (!empty($resultatsitems) || !empty($resultatslocations) || !empty($resultatsenemies)))
			{
				echo "<h1>Results</h1><br/>";
				if (!empty($resultatsitems))
				{
					echo "<h2>Items</h2>";
					echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>Type</th><th>Drop Amount</th></tr>";
					foreach($resultatsitems as $num){
						$num["NAME"]=preg_replace("/(".$search.")/i","<span id=\"surligne\">$1</span>", $num["NAME"]);
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
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"".$Type.".php\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
						else if ($Type=="helmets" || $Type=="chests" || $Type=="leggings" || $Type=="gauntlets")
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Armors.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
						else if ($Type=="miracles" || $Type=="pyromancies" || $Type=="sorceries")
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Spells.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
						else if ($Type=="consumables" || $Type=="ammos" || $Type=="multiplayeritems" || $Type=="bonfireitems" || $Type=="embers" || $Type=="ores" || $Type=="keys")
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Otheritems.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
						else if ($Type=="smallshields" || $Type=="normalshields" || $Type=="largeshields" ||$Type=="othershields")
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Shields.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
						else
							echo "<tr><td>".$num['NAME']."</td><td><a title=\"".$num['TYPE']."\" href=\"Ordinaryweapons.php?type=".$Type."\">".$num['TYPE']."</a></td><td>".$num['DROP_AMOUNT']."</td></tr>";
					}
					echo "</table><br/>";
				}
				if(!empty($resultatslocations))
				{
					echo "<h2>Locations</h2>";
					echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Location</th><th>Boss number</th><th>In DLC</th></tr>";
					foreach($resultatslocations as $num)
					{
						$num=preg_replace("/(".$search.")/i","<span id=\"surligne\">$1</span>", $num);
						if ($num['DLC']){$isdlc=" id=\"dlc\"";}
						else {$isdlc="";}
						echo "<tr><td".$isdlc.">".$num['NAME']."</td> <td".$isdlc.">".$num['BOSSES_NBR']."</td><td".$isdlc.">";
						if ($num['DLC']){
							echo "<a id=\"dlc\" href=\"/DLClocations.php\" title=\"DLC Locations\">Yes</a>";}
						else
						{
							echo "<a href=\"Basegamelocations.php\" title=\"Base Game Locations\">No</a>";
						}
						echo "</td></tr>";
					}
					echo "</table><br/>";
				}
				if (!empty($resultatsenemies1))
				{
					echo "<h2>Enemies</h2>";
					echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>HP</th><th>Localization</th><th>Death Amount</th></tr>";
					foreach($resultatsenemies1 as $num){
						$num=preg_replace("/(".$search.")/i","<span id=\"surligne\">$1</span>", $num);
						if ($num['BOSS']==1){echo "<tr id=\"boss\"><td><a id=\"boss\" href=\"Bosses.php\" title=\"Bosses\">".$num['NAME']."</a></td>";}
						else {echo "<tr><td><a href=\"Otherenemies.php\" title=\"Other Enemies\">".$num['NAME']."</a></td>";}
						$num2=$resultatsenemies2[$i];
						if ($num2['ID']==$num['ID'])
						{
							echo "<td>".$num['LIFE']."+".$num2['LIFE_SECOND_BOSS']."";
							if ($num2['LIFE_SUPER_BOSS_1']!=0)
							{
								echo " -> ".$num2['LIFE_SUPER_BOSS_1']." OR ".$num2['LIFE_SUPER_BOSS_2']."";
							}
							echo "</td>";
							$i=$i+1;
						}
						else
						{
							echo "<td>".$num['LIFE']."</td>";
						}
						echo "<td>".$num['LOCALIZATION']."</td><td>".$num['DEATH_AMOUNT']."</td></tr>";
					}
					echo "</table><br/>";
				}
			}
			else if($search!=NULL && $search!="CAR")
			{
				echo "<h3>No result found with term \"".$search."\" !</h3>";
			}
			else if ($search=="CAR")
			{
				echo "<h3>Special characters forbidden !</h3>";
			}
		?>
	</body>
</html>