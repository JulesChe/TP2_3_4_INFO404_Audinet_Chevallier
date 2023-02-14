<?php
	/**
		Crée toutes les tables en relation avec l'utilisateur.
	*/
    function cree_table_utilisateur() {
        include("db_connect.php");

        // Création de la Table MEMBRE
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
            //echo "Table utilisateurs créée avec succès";
        } else {
            echo "Erreur : " . mysqli_error(bdd());
        }



        // Création de la Table niveau, et insertion des niveaux
        $sql_niveau_table = "CREATE TABLE IF NOT EXISTS niveau (
                            id INT NOT NULL AUTO_INCREMENT,
                            nom VARCHAR (42),
                            PRIMARY KEY (id)
                            )";


        $sql_niveau_insert_d = "INSERT INTO niveau (nom) SELECT 'débutant' WHERE NOT EXISTS (SELECT * FROM niveau WHERE nom = 'débutant')";
        bdd()->query($sql_niveau_insert_d);

        $sql_niveau_insert_i = "INSERT INTO niveau (nom) SELECT 'intermédiaire' WHERE NOT EXISTS (SELECT * FROM niveau WHERE nom = 'intermédiaire')";
        bdd()->query($sql_niveau_insert_i);

        $sql_niveau_insert_e = "INSERT INTO niveau (nom) SELECT 'expert' WHERE NOT EXISTS (SELECT * FROM niveau WHERE nom = 'expert')";
        bdd()->query($sql_niveau_insert_e);

        $sql_niveau_insert_m = "INSERT INTO niveau (nom) SELECT 'mercenaire' WHERE NOT EXISTS (SELECT * FROM niveau WHERE nom = 'mercenaire')";
        bdd()->query($sql_niveau_insert_m);

        if (bdd()->query($sql_niveau_table) ) {
            //echo "Table niveaux créée avec succès";
        } else {
            echo "Erreur : " . mysqli_error(bdd());
        }



        // Création de la Table competence et insertion des competences
        $sql_competence_table = "CREATE TABLE IF NOT EXISTS competences (
                            id INT NOT NULL AUTO_INCREMENT,
                            nom VARCHAR (42),
                            PRIMARY KEY (id)
                            )";

        $sql_competence_insert_W = "INSERT INTO competences (nom) SELECT 'Web' WHERE NOT EXISTS (SELECT * FROM competences WHERE nom = 'Web')";
        bdd()->query($sql_competence_insert_W);

        $sql_competence_insert_M = "INSERT INTO competences (nom) SELECT 'Mobile' WHERE NOT EXISTS (SELECT * FROM competences WHERE nom = 'Mobile')";
        bdd()->query($sql_competence_insert_M);

        $sql_competence_insert_S = "INSERT INTO competences (nom) SELECT 'Serveurs' WHERE NOT EXISTS (SELECT * FROM competences WHERE nom = 'Serveurs')";
        bdd()->query($sql_competence_insert_S);

        if (bdd()->query($sql_competence_table) ) {
            //echo "Table competence créée avec succès";
        } else {
            echo "Erreur : " . mysqli_error(bdd());
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
            $sql_inscription = "INSERT INTO MEMBRE (login,mdp,date_naissance,niveau,description) VALUES ('$login', '$mot_de_passe', '$date_naissance', '$niveau', '$message')";
            bdd()->query($sql_inscription);
            $recup_id  = bdd()->insert_id;
            foreach($competences as $id_comp){
                $sql_membre_competence = "INSERT INTO competences(id_membre,id_competence) VALUES ('$recup_id', '$id_comp')";
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
        $sql_select_niveau = "SELECT id, nom FROM niveau";
        $result = bdd()->query($sql_select_niveau);
        $niveau = array();
        while($row = $result->fetch_assoc()) {
            $niveau[] = $row;
        }
        return $niveau;
    }

	/**
		Sélectionne toutes les compétences.
		@return la liste des compétences avec : id, nom.
	*/
	function recupere_competences() {
        $sql_select_competence = "SELECT id, nom FROM competences";
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