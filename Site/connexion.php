<?php
		try
		{
			$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u842844217_bd1;charset=utf8', 'Identifiant', 'Mot de passe');
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
?>