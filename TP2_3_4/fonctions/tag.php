<?php
	/**
		Crée toutes les tables en relation avec le tag.
	*/
	function cree_table_tag() {
	}

	/**
		Ajoute la liste des tags.
		@param id_sujet : l'id du sujet de la liste des tags.
		@param tags : la liste des tags.
		@return si les tags ont été ajoutés ou non.
	*/
	function ajoute_tag($id_sujet, $tags) {
		return false;
	}

	/**
		Sélectionne la liste de tous les tags.
		@return la liste des tags.
	*/
	function recupere_tag() {
		return array();
	}

	/**
		Sélectionne la liste des tags selon un sujet.
		@return la liste des tags selon un sujet.
	*/
	function recupere_tag_par_sujet($id_sujet) {
		return array();
	}
