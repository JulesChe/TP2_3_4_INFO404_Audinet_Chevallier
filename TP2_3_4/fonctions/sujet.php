<?php
	/**
		Crée toutes les tables en relation avec le sujet.
	*/
	function cree_table_sujet() {

		$sql_create = "CREATE TABLE IF NOT EXISTS SUJET(
			id	INT NOT NULL AUTO_INCREMENT,
			titre	VARCHAR(100) NOT NULL,
			description	VARCHAR(100),
			image	VARCHAR(300),
			date_creation DATE,
			idAuteur	INT,
			CONSTRAINT pk_SUJET PRIMARY KEY (id),
			CONSTRAINT fk_SUJET_MEMBRE FOREIGN KEY (idAuteur) REFERENCES MEMBRE (id)
		)";

		$sql_create_membre = "CREATE TABLE IF NOT EXISTS MEMBRESUJET(

			id INT NOT NULL AUTO_INCREMENT,
			idMembre INT,
			idSujet INT,
			CONSTRAINT pk_MEMBRESUJET PRIMARY KEY (id),
			CONSTRAINT fk_MEMBRES FOREIGN KEY (idMembre) REFERENCES MEMBRE (id),
			CONSTRAINT fk_SUJETM FOREIGN KEY (idSujet) REFERENCES SUJET (id)

		)";



		bdd()->query($sql_create);
		bdd()->query($sql_create_membre);
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

		$description=escapeshellcmd($description);
		$titre=escapeshellcmd($titre);

		$sql_insert = "INSERT INTO `SUJET`(`titre`, `description`, `image`,`date_creation`, `idAuteur`) VALUES ('$titre','$description','$image',now(),$id_auteur)";
		$res = bdd()->query($sql_insert);
		$last_id = bdd()->insert_id;
		ajoute_tag($last_id,$tags);
		modifie_point_utilisateur($id_auteur,30);

		return $res;
    }


	/**
		Compte les sujets selon l'id de son auteur.
		@param id_auteur : l'id de l'auteur du sujet.
		@return le nombre de sujets qui ont l'auteur donné.
	*/
	function compte_sujet_par_auteur($id_auteur) {

		$sql = "SELECT COUNT(*) FROM SUJET WHERE idAuteur = '$id_auteur'";
		$res = bdd()->query($sql);
		$res = $res->fetch_row()[0];

		return $res;
	}

	/**
		Sélectionne le sujet selon son id.
		@param id_sujet : l'id du sujet.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return l'objet sujet s'il est trouvé avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté); null sinon.
	*/
	function recupere_sujet_par_id($id_sujet, $id_utilisateur) {
		
		$sql_select = "SELECT s.id, s.titre, s.description, s.image, s.date_creation, m.login, 
		EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND ms.idSujet = s.id) AS favori
		FROM `SUJET` s 
		JOIN MEMBRE m ON m.id = s.idAuteur 
		WHERE s.id = $id_sujet
		";

		$res = bdd()->query($sql_select);

		$objSuj = array();

		foreach($res as $value){

			$objSuj = array(
				"id" => $value["id"],
				"titre" => $value["titre"],
				"login" => $value["login"],
				"date_creation" => $value["date_creation"],
				"description" => $value["description"],
				"image" => $value["image"],
				"favori" => $value["favori"]
			);
		}

		return $objSuj;

	}

	/**
		Sélectionne les sujets selon leur liste de tags.
		@param tags : la liste de tags.
		@param id_utilisateur : l'id de l'utilisateur connecté.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_sujet_par_tag($tags, $id_utilisateur) {

	
		$listetag = implode("','", $tags);
		$sql_select_tag = "SELECT s.id, s.titre, m.login, s.date_creation, s.description, s.image,
		EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND s.id = ms.idSujet) AS favori 
		FROM TAGSUJET ts 
		JOIN SUJET s ON s.id = ts.idSujet 
		JOIN MEMBRE m ON s.idAuteur = m.id 
		WHERE ts.nomTag IN ('$listetag')";

		$res = bdd()->query($sql_select_tag);

		$objSuj = array();

		foreach($res as $value){

			$objSuj[] = array(
				"id" => $value["id"],
				"titre" => $value["titre"],
				"login" => $value["login"],
				"date_creation" => $value["date_creation"],
				"description" => $value["description"],
				"image" => $value["image"],
				"favori" => $value["favori"]
			);
		}
		return $objSuj;
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

		if($id_auteur <= 0){

			$sql_select_limite ="SELECT DISTINCT s.id, s.titre, m.login, s.date_creation, s.description, s.image, 
			EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND s.id = ms.idSujet) AS favori 
			FROM SUJET s 
			LEFT JOIN MEMBRESUJET ms ON s.id = ms.idSujet 
			LEFT JOIN MEMBRE m ON ms.idMembre = m.id 
			ORDER BY s.date_creation ASC 
			LIMIT $limite OFFSET $decalage 
			 ";

		} else {

			$sql_select_limite ="SELECT DISTINCT s.id, s.titre, m.login, s.date_creation, s.description, s.image, 
			EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND s.id = ms.idSujet) AS favori 
			FROM SUJET s 
			LEFT JOIN MEMBRESUJET ms ON s.id = ms.idSujet 
			LEFT JOIN MEMBRE m ON ms.idMembre = m.id 
			WHERE s.idAuteur = $id_auteur
			ORDER BY s.date_creation ASC 
			LIMIT $limite OFFSET $decalage";
		}

		$res = bdd()->query($sql_select_limite);
		$objSuj = array();

		foreach($res as $value){

			$objSuj[] = array(
				"id" => $value["id"],
				"titre" => $value["titre"],
				"login" => $value["login"],
				"date_creation" => $value["date_creation"],
				"description" => $value["description"],
				"image" => $value["image"],
				"favori" => $value["favori"]
			);
		}

		return $objSuj;
	}

	/**
		Sélectionne les sujets liés aux messages postés par l'utilisateur donné.
		@param id_auteur : l'id de l'auteur des messages.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_sujet_par_message($id_auteur) {

		$sql_select_mess = "SELECT DISTINCT s.id, s.titre, m.login, s.date_creation, s.description, s.image, 
		EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_auteur AND s.id = ms.idSujet) AS favori 
		FROM SUJET s 
		JOIN MEMBRE m ON m.id = s.idAuteur 
		LEFT JOIN MESSAGES mes ON s.id = mes.id_sujet 
		WHERE mes.id_auteur = $id_auteur";


		$res = bdd()->query($sql_select_mess);
		$objSuj = array();

		foreach($res as $value){

			$objSuj[] = array(
				"id" => $value["id"],
				"titre" => $value["titre"],
				"login" => $value["login"],
				"date_creation" => $value["date_creation"],
				"description" => $value["description"],
				"image" => $value["image"],
				"favori" => $value["favori"]
			);
		}

		return $objSuj;
	}

	/**
		Ajoute/supprime un favori.
		@param id_utilisateur : l'id de l'utilisateur.
		@param id_sujet : l'id du sujet.
		@return si le favori a été ajouté/supprimé ou non.
	*/
	function ajoute_ou_supprime_favori($id_utilisateur, $id_sujet) {

		$results = false;
		$select_fav = " SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND ms.idSujet = $id_sujet";

		$res = bdd()->query($select_fav);

		if($res->num_rows == 0){

			$insert_fav = "INSERT INTO MEMBRESUJET (idMembre,idSujet) VALUES ($id_utilisateur,$id_sujet)";
			bdd()->query($insert_fav);
			$results = true;
			
		} else if($res->num_rows == 1) {

			$delete_fav = "DELETE FROM `MEMBRESUJET` WHERE idMembre = $id_utilisateur AND idSujet = $id_sujet";
			bdd()->query($delete_fav);
			$results =true;
		}


		return $results;
	}

	/**
		Sélectionne les sujets mis en favoris par l'utilisateur donné.
		@param id_utilisateur : l'id de l'utilisateur.
		@return la liste des sujets avec : id, titre, login (le login de l'auteur), date_creation, description, image, favori (s'il est favori de l'utilisateur connecté).
	*/
	function recupere_favori($id_utilisateur) {


		$sql_select_fav = "SELECT DISTINCT s.id, s.titre, m.login, s.date_creation, s.description, s.image, 
		EXISTS(SELECT * FROM MEMBRESUJET ms WHERE ms.idMembre = $id_utilisateur AND s.id = ms.idSujet) AS favori 
		FROM SUJET s 
		JOIN MEMBRESUJET ms ON ms.idSujet = s.id 
		JOIN MEMBRE m ON m.id = ms.idMembre 
		WHERE ms.idMembre = $id_utilisateur";

		$res = bdd()->query($sql_select_fav);
		$objSuj = array();

		foreach($res as $value){

			$objSuj[] = array(
				"id" => $value["id"],
				"titre" => $value["titre"],
				"login" => $value["login"],
				"date_creation" => $value["date_creation"],
				"description" => $value["description"],
				"image" => $value["image"],
				"favori" => $value["favori"]
			);
		}

		return $objSuj;
	}
