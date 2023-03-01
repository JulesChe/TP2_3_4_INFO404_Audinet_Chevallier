<?php
	/**
		Crée toutes les tables en relation avec l'utilisateur.
	*/
    function cree_table_utilisateur() {
        bdd()->query("CREATE TABLE IF NOT EXISTS  `MEMBRE` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`login` VARCHAR(42),
			`mot_de_passe` VARCHAR(42),
			`date_naissance` DATE,
			`description` VARCHAR(42),
			`point` INT DEFAULT(0),
			`niveau` INT,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`niveau`) REFERENCES NIVEAU(`id`)
		)");		

		bdd()->query("CREATE TABLE IF NOT EXISTS `COMPETENCE` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`nom` VARCHAR(42),
			PRIMARY KEY (`id`)
			)");

		bdd()->query(
			"CREATE TABLE IF NOT EXISTS  `NIVEAU` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`nom` VARCHAR(42),
			PRIMARY KEY (`id`)
			)");

		bdd()->query(
			"CREATE TABLE IF NOT EXISTS `COMPETENCES_MEMBRE` (
			`idCompetence` INT,
			`idUtilisateur` INT,
			PRIMARY KEY (`idCompetence`, `idUtilisateur`),
			FOREIGN KEY (`idCompetence`) REFERENCES COMPETENCE(`id`),
			FOREIGN KEY (`idUtilisateur`) REFERENCES MEMBRE(`id`)
			)");

    }


/**
		Ajoute un utilisateur.
		@param login : le login de l'utilisateur.
		@param mot_de_passe : le mot de passe de l'utilisateur.
		@param confirmation : la confirmation du mot de passe de l'utilisateur.
		@param date_naissance : la date de naissance de l'utilisateur.
		@param niveau : le niveau de l'utilisateur.
		@param competences : la liste des ids des compétences de l'utilisateur.
		@param message : le message de l'utilisateur qui le décrit.
		@return si l'utilisateur a été ajouté ou non.
	*/
    function inscrit_utilisateur($login, $mot_de_passe, $confirmation, $date_naissance, $niveau, $competences, $message) {
        // Vérification du mot de passe
		if ($mot_de_passe != $confirmation) {
			return false;
		}
		
		// Insertion de l'utilisateur
		$sql = "INSERT INTO MEMBRE (login, mot_de_passe, date_naissance, niveau, description)
		VALUES ('$login', '$mot_de_passe', '$date_naissance', '$niveau', '$message')";
		$result = bdd()->query($sql);

		if (!$result) {
			return false;
		}

		// Récupération de l'ID de l'utilisateur inséré
		$id_utilisateur = bdd()->insert_id;

		// Insertion des compétences pour cet utilisateur
		foreach ($competences as $competence) {
			$sql = "INSERT INTO COMPETENCES_MEMBRE (idUtilisateur, idCompetence)
					VALUES ('$id_utilisateur', '$competence')";
			$result = bdd()->query($sql);
			if (!$result) {
				return false;
			}
		}


		return true;
}



// INSERT INTO `MEMBRE` (login, mdp, datenaissance, niveau_sql, competence, nbpoints, messagemembre) VALUES ("baptiste", "blabla", 16/02/2003, null , null, 0, "yoyo")


/**
		Sélectionne l'utilisateur selon son login et son mot de passe.
		@param login : le login de l'utilisateur.
		@param mot_de_passe : le mot de passe de l'utilisateur.
		@return l'objet utilisateur s'il est trouvé avec : id, login, point (son nombre de points); null sinon.
	*/
	function connecte_utilisateur($login, $mot_de_passe) {
        $sql = "SELECT * FROM MEMBRE WHERE login='$login' AND mot_de_passe='$mot_de_passe'";
		$result = bdd()->query($sql);
	
		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row;
		} else {
			return null;
		}
	}

	/**
		Sélectionne tous les niveaux.
		@return la liste des niveaux avec : id, nom.
	*/
    function recupere_niveaux() {
		$sql = "SELECT * FROM NIVEAU";
		$result = bdd()->query($sql);
		return $result;
    }

	/**
		Sélectionne toutes les compétences.
		@return la liste des compétences avec : id, nom.
	*/
	function recupere_competences() {
		$sql_select_competence = "SELECT id, nom FROM COMPETENCE";
		$result = bdd()->query($sql_select_competence);
		$competences = array();
		while($row = $result->fetch_assoc()) {
			$competences[] = $row;
		}
		return $competences;
	}

	/**
		Sélectionne l'utilisateur selon son id.
		@param id : l'id de l'utilisateur.
		@return l'objet utilisateur s'il est trouvé avec : id, login, date_naissance, niveau, competences (liste des ids des compétences), message, point (son nombre de points); null sinon.
	*/
	function recupere_utilisateur($id) {
		$select = bdd()->query("SELECT * FROM MEMBRE WHERE id='$id'");
		$user = array();
		$id_competence_array = array();
		if($result = $select->fetch_assoc()){
			$user['id'] = $result['id'];
			$user['login'] = $result['login'];
			$user['date_naissance'] = $result['date_naissance'];
			$user['niveau'] = $result['niveau'];
			$user['message'] = $result['description'];
			$user['point'] = $result['point'];
			$sql_select_competence = "SELECT idCompetence FROM COMPETENCES_MEMBRE WHERE idUtilisateur='$id'";
			$competences = bdd()->query($sql_select_competence);
			while($row = $competences->fetch_assoc()) {
				$user['competences'][] = $row['idCompetence'];
			}
			return $user;
		}else{
			return false;
		}
	}

	/**
		Modifie le niveau, la liste des compétences et le message de l'utilisateur.
		@param id : l'id de l'utilisateur.
		@param niveau : le niveau de l'utilisateur.
		@param competences : la liste des ids des compétences de l'utilisateur.
		@param message : le message de l'utilisateur qui le décrit.
		@return si le niveau, les compétences et le message de l'utilisateur ont été modifiés ou non.
	*/
	function modifie_information_utilisateur($id, $niveau, $competences, $message) {
		$update = "UPDATE UTILISATEUR SET niveau = '$niveau', description = '$message' WHERE id='$id'";
		if(bdd()->query($update)){
			$sql_del_comp = "DELETE FROM `COMPETENCES_MEMBRE` WHERE idUtilisateur = '$id'";
			if(bdd()->query($sql_del_comp)){
				foreach($competences as $id_comp){
					$sql_utilisateur_competence = "INSERT INTO `COMPETENCES_MEMBRE`(`idUtilisateur`,`idCompetence`) VALUES ('$id', '$id_comp')";	
					bdd()->query($sql_utilisateur_competence);
				}
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}

	/**
		Modifie le mot de passe de l'utilisateur.
		@param id : l'id de l'utilisateur.
		@param ancien_mot_de_passe : l'ancien mot de passe de l'utilisateur.
		@param mot_de_passe : le mot de passe de l'utilisateur.
		@param confirmation : la confirmation du mot de passe de l'utilisateur.
		@return si le mot de passe de l'utilisateur a été modifié ou non.
	*/
	function modifie_mot_de_passe_utilisateur($id, $ancien_mot_de_passe, $mot_de_passe, $confirmation) {
		$sql_ancien_mdp = "SELECT mot_de_passe FROM MEMBRE WHERE id = '$id'";
		$res_ancien_mdp = bdd()->query($sql_ancien_mdp);
		$res_ancien_mdp_fetch = $res_ancien_mdp->fetch_assoc();
		if($res_ancien_mdp_fetch['mot_de_passe'] == $ancien_mot_de_passe){
			if($mot_de_passe == $confirmation){
				$sql_update_mdp = "UPDATE MEMBRE SET mot_de_passe = '$mot_de_passe' WHERE id = '$id'";
				if(bdd()->query($sql_update_mdp)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
		Modifie le nombre de points de l'utilisateur.
		@param id : l'id de l'utilisateur.
		@param point : le nombre de point de l'utilisateur.
		@return si le nombre de points de l'utilisateur a été modifié ou non.
	*/
	function modifie_point_utilisateur($id, $point) {
		return false;
	}