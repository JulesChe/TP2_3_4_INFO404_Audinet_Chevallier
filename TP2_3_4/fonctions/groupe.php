<?php

	/**
		Crée toutes les tables en relation avec le groupe.
	*/
	function cree_table_groupe() {

	}

	/**
		Ajoute un groupe.
		@param nom : le nom du groupe.
		@param id_proprietaire : l'id du propriétaire du groupe.
		@return si le groupe a été ajouté ou non.
	*/
	function ajoute_groupe($nom, $id_proprietaire) {
/* 
		include("db_connect.php");

		$stm = $PDO->prepare("INSERT INTO `GROUPE`(`nomgrp`, `idmembre`) VALUES (:nomgrp,:idmembre);");
		$stm->bindValue(":nomgrp", $_POST[$nom]);
		$stm->bindValue(":idmembre", $_POST[$id_proprietaire]);
	
		$stm->execute();
		

		return $stm; */
	}
	
	/**
		Sélectionne le groupe selon son id.
		@param id : l'id du groupe.
		@return l'objet groupe s'il est trouvé avec : id, nom, id_proprietaire; null sinon.
	*/
	function recupere_groupe_par_id($id) {

/* 		include("db_connect.php");

		$stm = $PDO->prepare("SELECT * FROM `GROUPE` WHERE `idgroupe` = :idgroupe");
		
		$stm->bindValue(":idgroupe", $_POST[$id]);
	
		$stm->execute();

		return $stm; */
	}
	
	/**
		Sélectionne la liste des groupes selon leur id.
		@param ids : la liste des ids du groupe.
		@return la liste des groupes avec : id, nom, membres (liste avec : id, login, valide).
	*/
	function recupere_groupe_par_ids($ids) {
		include("db_connect.php");

		foreach ($ids as $id) {

			$stm = $PDO->prepare("SELECT g.idgroupe, g.nomgrp,m.idmembre,m.login 
			FROM `GROUPE` g INNER JOIN REJOINDRE r ON g.idgroupe = r.idgroupe 
			INNER JOIN MEMBRE m ON r.idmembre = m.idmembre");

			$stm->execute();

			$stm = $results->fetch_array();

			
		}

		return array();
	}
	
	/**
		Sélectionne la liste des ids des groupes selon l'id de leur propriétaire.
		@param id_proprietaire : l'id du propriétaire.
		@return la liste des ids.
	*/
	function recupere_id_groupe_par_proprietaire($id_proprietaire) {
		return array();
	}
	
	/**
		Sélectionne la liste des ids des groupes où se trouve l'utilisateur connecté.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return la liste des ids.
	*/
	function recupere_id_groupe_par_membre($id_utilisateur) {
		return array();
	}
	
	/**
		Sélectionne la liste des ids des groupes où ne se trouve pas l'utilisateur connecté.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return la liste des ids.
	*/
	function recupere_id_groupe_par_non_membre($id_utilisateur) {
		return array();
	}

	/**
		Supprime un groupe.
		@param id_proprietaire : l'id du propriétaire.
		@param id_groupe : l'id du groupe.
		@return si le groupe a été supprimé ou non.
	*/
	function supprime_groupe($id_proprietaire, $id_groupe) {
		return false;
	}

	/**
		Ajoute un membre dans un groupe.
		@param id_utilisateur : l'id du membre.
		@param id_groupe : l'id du groupe.
		@return si le membre a été ajouté ou non.
	*/
	function ajoute_membre($id_utilisateur, $id_groupe) {
		return false;
	}

	/**
		Valide un membre dans un groupe.
		@param id_utilisateur : l'id du membre.
		@param id_proprietaire : l'id du propriétaire.
		@param id_groupe : l'id du groupe.
		@return si le membre a été validé ou non.
	*/
	function valide_membre($id_utilisateur, $id_proprietaire, $id_groupe) {
		return false;
	}

	/**
		Supprime un membre dans un groupe.
		@param id_utilisateur : l'id du membre.
		@param id_groupe : l'id du groupe.
		@return si le membre a été supprimé ou non.
	*/
	function supprime_membre($id_utilisateur, $id_groupe) {
		return false;
	}