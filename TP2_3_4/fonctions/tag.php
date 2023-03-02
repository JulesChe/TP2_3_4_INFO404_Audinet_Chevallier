<?php
	/**
		Crée toutes les tables en relation avec le tag.
	*/
	function cree_table_tag() {

		$sql_tag ="CREATE TABLE IF NOT EXISTS TAG (
			nom	VARCHAR(50),
			CONSTRAINT pk_TAG PRIMARY KEY (nom)
		)";

		$sql_tag_sujet ="CREATE TABLE IF NOT EXISTS TAGSUJET ( 
			idSujet INT, 
			nomTag VARCHAR(50), 
			CONSTRAINT fk_SUJET FOREIGN KEY (idSujet) REFERENCES SUJET (id), 
			CONSTRAINT fk_TAG FOREIGN KEY (nomTag) REFERENCES TAG (nom)
		)";


		bdd()->query($sql_tag);
		bdd()->query($sql_tag_sujet);
	}

	/**
		Ajoute la liste des tags.
		@param id_sujet : l'id du sujet de la liste des tags.
		@param tags : la liste des tags.
		@return si les tags ont été ajoutés ou non.
	*/
	function ajoute_tag($id_sujet, $tags) {

		if(!empty($tags)){
			foreach($tags as $value){
				$sql_join = "INSERT INTO `TAG`( `nom`) VALUES ($value)";
				$sql_tagsujet = "INSERT INTO `TAGSUJET`(`idSujet`, `nomTag`) VALUES ($id_sujet,$value)"
			}
			return true;
		}

		return false;
	}

	/**
		Sélectionne la liste de tous les tags.
		@return la liste des tags.
	*/
	function recupere_tag() {
		$sql = "SELECT * FROM TAG";
        return bdd()->query($sql);
	}

	/**
		Sélectionne la liste des tags selon un sujet.
		@return la liste des tags selon un sujet.
	*/
	function recupere_tag_par_sujet($id_sujet) {
		$select = bdd()->query("SELECT * FROM MEMBRE WHERE id_sujet='$id_sujet'");
        $sujet = array();

        if($result = $select->fetch_assoc()){
            $sujet['id_sujet'] = $result['id_sujet'];
        }
        return $result();
	}

