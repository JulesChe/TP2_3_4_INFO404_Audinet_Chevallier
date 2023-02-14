<?php
	/**
		Crée toutes les tables en relation avec l'utilisateur.
	*/
    function cree_table_utilisateur() {
        include("db_connect.php");

        $query = "CREATE TABLE IF NOT EXISTS MEMBRE (
                    idmembre INT NOT NULL AUTO_INCREMENT,
                    login VARCHAR(42),
                    mdp VARCHAR(42),
                    datenaissance DATETIME,
                    niveau_sql ENUM('débutant', 'intermediaire', 'expert'),
                    competence VARCHAR(42),
                    nbpoints INT,
                    messagemembre VARCHAR(45),
                    PRIMARY KEY (idmembre)
                  ) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4";

        if (bdd()->query($query) ) {
            echo "Table utilisateurs créée avec succès";
            return true;
        } else {
            echo "Erreur : " . mysqli_error(bdd());
        }

        if ($mysqli->query($query) === TRUE) {
            return true;
        } else {
            return "Erreur lors de la création de la table : " . $mysqli->error;
        }

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
        if($mot_de_passe !== $confirmation){
            return false;
        }
        try {
            $sql_inscription = "INSERT INTO Membre (login,mdp,date_naissance,niveau,description) VALUES ('$login', '$mot_de_passe', '$date_naissance', '$niveau', '$message')";
            bdd()->query($sql_inscription);
            $recup_id  = bdd()->insert_id;
            foreach($competences as $id_comp){
                $sql_membre_competence = "INSERT INTO Competence_membre(id_membre,id_competence) VALUES ('$recup_id', '$id_comp')";
                bdd()->query($sql_membre_competence);
            }
            return true;

          } catch (Exception $e) {
    return "Une erreur s'est produite lors de l'inscription de l'utilisateur : " . $e->getMessage();
    }
}



// INSERT INTO `MEMBRE` (login, mdp, datenaissance, niveau_sql, competence, nbpoints, messagemembre) VALUES ("baptiste", "blabla", 16/02/2003, null , null, 0, "yoyo")


/**
		Sélectionne l'utilisateur selon son login et son mot de passe.
		@param login : le login de l'utilisateur.
		@param mot_de_passe : le mot de passe de l'utilisateur.
		@return l'objet utilisateur s'il est trouvé avec : id, login, point (son nombre de points); null sinon.
	*/
	function connecte_utilisateur($login, $mot_de_passe) {
		return null;
	}

	/**
		Sélectionne tous les niveaux.
		@return la liste des niveaux avec : id, nom.
	*/
	function recupere_niveaux() {



	}

	/**
		Sélectionne toutes les compétences.
		@return la liste des compétences avec : id, nom.
	*/
	function recupere_competences() {

	}

	/**
		Sélectionne l'utilisateur selon son id.
		@param id : l'id de l'utilisateur.
		@return l'objet utilisateur s'il est trouvé avec : id, login, date_naissance, niveau, competences (liste des ids des compétences), message, point (son nombre de points); null sinon.
	*/
	function recupere_utilisateur($id) {
		return null;
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
		return false;
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
		return false;
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