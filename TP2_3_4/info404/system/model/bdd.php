<?php
	$_bdd = null;
	function bdd() {
		global $_bdd, $utilisateur, $mot_de_passe;
		if (basename(getcwd()) != "system") {
			if ($_bdd === null)  {
				$_bdd = new mysqli("localhost", $utilisateur, $mot_de_passe);
				$_bdd->set_charset("utf8");
				$_bdd->query("CREATE DATABASE IF NOT EXISTS $utilisateur");
				$_bdd->select_db($utilisateur);
			}
		} else {
			$GLOBALS['_bdd'] = null;
		}
		return $GLOBALS['_bdd'];
	}

	if (basename(getcwd()) != "system") {
		if ($bdd = @mysqli_connect("localhost", $utilisateur, $mot_de_passe)) {
			mysqli_set_charset($bdd, "utf8");
			mysqli_query($bdd, "CREATE DATABASE IF NOT EXISTS $utilisateur");
			mysqli_select_db($bdd, $utilisateur);
		} else {
			unset($bdd);
		}
	}
