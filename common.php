<?php 

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is a common PHP file that defines the generic structure of other php scripts. It also
# connects to the database to grant retrieval and manipulation of data in the database.

error_reporting(E_ALL & E_STRICT);

$db = new PDO("mysql:dbname=hw7;host=localhost;charset=utf8", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header("Content-Type: application/json");

?>