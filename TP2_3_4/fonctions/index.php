<?php
	// C'est au sein de chaque fichier que le code PHP en lien avec le modèle du site doit être écrit.
	// Pas toucher !
	include_once "utilisateur.php";
	include_once "sujet.php";
	include_once "tag.php";
	include_once "message.php";
	include_once "groupe.php";

	// Précise les identifiants pour se connecter à la base de données.
	// Toucher !
	$utilisateur = "gr1_8";
	$mot_de_passe = "CC4";

	// Inclut l'autre moitié du site (connexion à la base, vue et contrôleur).
	// Pas toucher !
	require_once "../info404/index.php";

	// Pour la suite du TP, chaque fois que vous souhaitez communiquer avec la base de données choisissez :
	// - soit la fonction bdd(), qui renvoie l'instance de connexion à la base de données en version objet ;
	// - soit la variable $bdd, qui contient la connexion à la base de données en version impérative.

	// Les appels seront forcément différent. Par exemple, pour effectuer une requête :
	// - en version objet, $result = bdd()->query($sql);
	// - en version impérative, $result = mysqli_query($bdd, $sql);

	// Choisissez la version avec laquelle vous êtes la plus à l'aise.
	// Bon courage !