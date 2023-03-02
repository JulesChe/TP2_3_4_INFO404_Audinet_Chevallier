<?php
	/**
		Crée toutes les tables en relation avec le sujet.
	*/
	function cree_table_sujet() {

		$sql_create = "CREATE TABLE IF NOT EXISTS SUJET(
			id	INT NOT NULL AUTO_INCREMENT,
			titre	VARCHAR(50) NOT NULL,
			description	VARCHAR(60),
			image	VARCHAR(50),
			date_creation DATE,
			idAuteur	INT,
			CONSTRAINT pk_SUJET PRIMARY KEY (id),
			CONSTRAINT fk_SUJET_MEMBRE FOREIGN KEY (idAuteur) REFERENCES MEMBRE (id)
		)";

		bdd()->query($sql_create);
	}

	/**
		Ajoute un sujet.
		@param titre : le titre du sujet.
		@param id_auteur : l'id de l'auteur du sujet.
		@param description : la description du sujet.
		@param image : l'image du sujet.
		@param tags : la liste des tags.
		@return si le sujet a été ajouté ou non.
	*/
	function ajoute_sujet($titre, $id_auteur, $description, $image, $tags) {

		$sql_insert = "INSERT INTO `SUJET`(`titre`, `description`, `image`, `idAuteur`) VALUES ($titre,$description,$image,$id_auteur)";
		bdd()->query($sql_insert);
		$last_id = bdd()->insert_id;
		ajoute_tag($last_id,$tags);

		return true;
    }


	/**
		Compte les sujets selon l'id de son auteur.
		@param id_auteur : l'id de l'auteur du sujet.
		@return le nombre de sujets qui ont l'auteur donné.
	*/
	function compte_sujet_par_auteur($id_auteur) {

		$sql = "SELECT COUNT(*) FROM SUJET WHERE idAuteur = '$id_auteur'";
		$res = bdd()->query($sql);

		return $res;
	}

	/**
		Sélectionne le sujet selon son id.
		@param id_sujet : l'id du sujet.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return l'objet sujet s'il est trouvé avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté); null sinon.
	*/
	function recupere_sujet_par_id($id_sujet, $id_utilisateur) {
		return null;
	}

	/**
		Sélectionne les sujets selon leur liste de tags.
		@param tags : la liste de tags.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_sujet_par_tag($tags, $id_utilisateur) {
		return array();
	}

	/**
		Sélectionne les sujets pour la pagination.
		@param limite : nombre de sujets par page.
		@param decalage : nombre de sujets à passer.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@param id_auteur : l'id de l'auteur du sujet (pris en compte si supérieur à 0).
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_sujet_par_date($limite, $decalage, $id_utilisateur, $id_auteur = 0) {
		return array();
	}

	/**
		Sélectionne les sujets liés aux messages postés par l'utilisateur donné.
		@param id_auteur : l'id de l'auteur des messages.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_sujet_par_message($id_auteur) {
		return array();
	}

	/**
		Ajoute/supprime un favori.
		@param id_utilisateur : l'id de l'utilisateur.
		@param id_sujet : l'id du sujet.
		@return si le favori a été ajouté/supprimé ou non.
	*/
	function ajoute_ou_supprime_favori($id_utilisateur, $id_sujet) {
		return false;
	}

	/**
		Sélectionne les sujets mis en favoris par l'utilisateur donné.
		@param id_utilisateur : l'id de l'utilisateur.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_favori($id_utilisateur) {
		return array();
	}
