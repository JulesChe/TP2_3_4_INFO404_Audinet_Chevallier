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

/*         try {
            include("db_connect.php");
            $stm = $PDO -> prepare("INSERT INTO sujets (titre, id_auteur, description, image, tags) 
        VALUES (:titre, :id_auteur, :description, :image, :tags)");
            $stm->bindValue(':titre', $titre);
            $stm->bindValue(':id_auteur', $id_auteur);
            $stm->bindValue(':description', $description);
            $stm->bindValue(':image', $image);
            $stm->bindValue(':tags', null);
            $stm->execute();

            return true;
        }
        catch (Exception $e){
            echo "une erreur s'est produite lors de l'ajout d'un sujet" . $e -> getMessage();
        }
        return false; */
    }


	/**
		Compte les sujets selon l'id de son auteur.
		@param id_auteur : l'id de l'auteur du sujet.
		@return le nombre de sujets qui ont l'auteur donné.
	*/
	function compte_sujet_par_auteur($id_auteur) {

/*         try {
            include("db_connect.php");

            $stm = $PDO -> prepare(" SELECT COUNT(*) FROM SUJET WHERE idmembre = idauteur");
            $stm -> execute();


            return true;
        }
        catch (Exception $e){
            echo "une erreur s'est produite lors du comptage des sujet " . $e -> getMessage();
        } */
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
