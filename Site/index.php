<?php
	include('connexion.php');
	if (!empty($_POST)) {
		$sql="SELECT * FROM USER";
		$requete = $bdd->query($sql);
		$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
		echo "<h5>Successfully logged in !</h5>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
		<script type="text/javascript" src="angular.min.js"></script>
		<script type="text/javascript" src="app.js"></script>
		<title>Dark Souls</title>
	</head>
	<body>
		<h1>Dark Souls</h1>
		<?php include 'menus/menu.php'; ?>
	</body>
</html>