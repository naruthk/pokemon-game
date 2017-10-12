<?php

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is an insert PHP file that adds a new Pokemon into the database. The user can choose to
# include a nickname for the Pokemon too. If not, then the nickname will be an uppercase version
# of the given Pokemon name. Successful and failure outputs are sent back as JSON data.

include 'common.php'; 

// Ensures that the name parameter is passed. Verifies name is not an empty string.
if (!isset($_POST["name"]) || $_POST["name"] == "") {
    header("HTTP/1.1 400 bad request");
    die(json_encode([ "error" => "Missing name parameter." ]));
}

$name = $_POST["name"];             // Name of Pokemon
$nickname = "";                     // Nickname of Pokemon

// Use name in all caps if nickname is not provided by the user
if (!isset($_POST["nickname"])) {  
    $nickname = strtoupper($_POST["name"]);
} else {
    $nickname = $_POST["nickname"];
}

// Adjust time zone and set time.
date_default_timezone_set('America/Los_Angeles');
$time = date('y-m-d H:i:s');

// Try inserting the POST parameters into the database. Outputs success or error depending on
// the results of the database call.
try {
    $db->query("
        INSERT INTO Pokedex (name, nickname, datefound) 
        VALUES ('{$name}', '{$nickname}', '{$time}')");
    print(json_encode([ "success" => "Success! Pokemon {$name} added to your Pokedex!" ]));
    
} catch (PDOException $pdoex) {
    header("HTTP/1.1 400 bad request");
    print(json_encode([ "error" => "Error: Pokemon {$name} already found." ]));
}

?>