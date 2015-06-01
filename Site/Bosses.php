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
		<title>Bosses</title>
	</head>
	<body>
		<h1>Bosses</h1>
		<?php
			include ('menus/menuhor1.php');
			include ('menus/menu.php');
			$sql = 'SELECT DISTINCT E.ID, E.DEATH_AMOUNT, E.NAME, E.LIFE, L.NAME AS LOCALIZATION FROM LOCATION L, ENEMY E, IS_LOCATED WHERE L.ID=ID_LOCATION AND E.ID=ID_ENEMY AND E.BOSS=1 ORDER BY L.ID, E.ID';
			$requete = $bdd->query($sql);
			$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
			$sql2='SELECT E.ID, D.ID_ENEMY, D.LIFE_SECOND_BOSS, D.LIFE_SUPER_BOSS_1, D.LIFE_SUPER_BOSS_2 FROM DOUBLE_BOSS D, ENEMY E WHERE ID=ID_ENEMY';
			$requete2 = $bdd->query($sql2);
			$resultats2 = $requete2->fetchAll(PDO::FETCH_ASSOC);
			$i=0;
			echo "<table class=\"sortable\" border=1 align=\"center\"><tr id=\"entete\"><th>Name</th><th>HP</th><th>Localization</th><th>Death Amount</th></tr>";
			foreach($resultats as $num){
				echo "<tr id=\"boss\"><td>".$num['NAME']."</td>";
				$num2=$resultats2[$i];
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
					echo "<td>".$num['LIFE']."</td>";
				echo "<td>".$num['LOCALIZATION']."</td><td>".$num['DEATH_AMOUNT']."   <a href=\"Bosses.php?add=".$num['ID']."\"><button type=\"button\">ADD</button></a></td></tr>";
			}
			echo "</table>";
		?>
		
	</body>
</html>