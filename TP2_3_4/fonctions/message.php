<?php
	/**
		Crée toutes les tables en relation avec le message.
	*/
	function cree_table_message() {
        $sql = "CREATE TABLE IF NOT EXISTS  `MESSAGES` (
    
			`idmessage` INT NOT NULL AUTO_INCREMENT,
			`id_sujet` VARCHAR(42),
			`id_auteur` VARCHAR(42),
			`texte` VARCHAR(140),
    
			CONSTRAINT pk_MESSAGES PRIMARY KEY (`idmessage`)
		)";
        bdd()->query($sql);
	}

	/**
		Ajoute un message.
		@param texte : le texte du message.
		@param id_sujet : l'id du sujet du message.
		@param id_auteur : l'id de l'auteur du message.
		@return si le message a été ajouté ou non.
	*/
	function ajoute_message($texte, $id_sujet, $id_auteur) {
        $sql_insert = "INSERT INTO `MESSAGES`(`id_sujet`, `id_auteur`, `texte`) VALUES ('$id_sujet','$id_auteur','$texte')";
        bdd()->query($sql_insert);
        return true;
	}

	/**
		Sélectionne les messages selon le sujet.
		@param id_sujet : l'id du sujet du message
		@return la liste des messages avec : id, texte, id_auteur, login (le login de l'auteur), date_creation.
	*/
    function recupere_message_par_sujet($id_sujet) {
        $sql = "SELECT m.idmessage, m.texte, m.id_auteur, membre.login, m.date_creation FROM MESSAGES m JOIN MEMBRE ON m.id_auteur = membre.id WHERE m.id_sujet = '$id_sujet'";
        $resultat = bdd()->query($sql);

        $tableau_resultats = array();
        while ($ligne = $resultat->fetch_assoc()) {
            $tableau_resultats[] = $ligne;
        }

        return $tableau_resultats;
    }

	/**
		Supprime un message.
		@param id : l'id du message.
		@return si le message a été supprimé ou non.
	*/
	function supprime_message($id) {
        $sql = "DELETE FROM MESSAGES WHERE idmessage = '$id'";

        if (bdd()-> query($sql) === TRUE){
            $res = true;
        }
        else{
            $res =  false;
        }
        return $res;
	}
