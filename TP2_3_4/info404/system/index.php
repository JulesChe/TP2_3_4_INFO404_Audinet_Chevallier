<?php
	include_once "model/bdd.php";
	if (isset($bdd) && (bdd() !== null)) {
		session_start();

		cree_table_utilisateur();
		cree_table_sujet();
		cree_table_tag();
		cree_table_message();
		cree_table_groupe();

		include_once "controller/action.php";
		include_once "view/template.php";
	} else {
		include_once "view/error.php";
	}