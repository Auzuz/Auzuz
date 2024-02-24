<?php 
$db_host = 'localhost';
$db_name = 'id21888232_ogonijobhub';
$db_username = 'id21888232_root';
$db_password = 'Ogonijobhub@2024';

// dsn = data source name
$dsn = "mysql:host=$db_host;dbname=$db_name";
try{
    $db_connection = new PDO($dsn, $db_username, $db_password);
} catch(Exception $e){
    echo "there was an error loading the page-".$e->getMessage();
}

// id21888232_ogonijobhub

// id21888232_root

// localhost
