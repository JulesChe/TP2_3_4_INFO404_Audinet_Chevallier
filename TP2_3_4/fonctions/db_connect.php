<?php

include ('db_config.php');

// Connexion à la base de données
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Vérification de la connexion
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Configuration de l'encodage en utf8
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
}

?>
