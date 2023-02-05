<?php

require 'db_config.php';
try{

    $options = [

        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    $PDO = new PDO($db_dsn,$db_user,$db_pass,$options);

}

catch(PDOException $pe){

    echo 'ERREUR : '. $pe ->getMessage();
}

?>