<?php

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is a trade PHP file that accepts two parameters (user's pokemon name and opponent's pokemon
# name) and then trades the two Pokemon if possible. Successful and failure outputs are sent back as
# JSON data.

include "common.php";

if (!(isset($_POST["mypokemon"]) 
        && isset($_POST["theirpokemon"])) 
        || $_POST["mypokemon"] == "" 
        || $_POST["theirpokemon"] == "") {
    header("HTTP/1.1 400 bad request"); 
    die(json_encode([ "error" => "Missing mypokemon and theirpokemon parameters." ]));
}

$mypokemon = $_POST["mypokemon"];
$theirpokemon = $_POST["theirpokemon"];

# Check to see if I own the Pokemon I want to trade
$result_set = $db->query("SELECT (name) FROM Pokedex WHERE name = '{$mypokemon}'");

$row_count = $result_set -> rowCount();       // Count the number of rows affected in MYSQL, 
if ($row_count == 0) {                       // Pokemon does not exist, didn't delete anything.
    header("HTTP/1.1 400 bad request");
    die(print(json_encode([ "error" => "Error: Pokemon {$mypokemon} not found in your Pokedex." ])));
}

# Now, add theirpokemon to my Pokedex if I never found it before
try {
    $their_pokemon_nickname = strtoupper($theirpokemon);
    date_default_timezone_set('America/Los_Angeles');
    $time = date('y-m-d H:i:s');
    
    $db->query(
        "INSERT INTO Pokedex (name, nickname, datefound) 
        VALUES ('{$theirpokemon}', '{$their_pokemon_nickname}', '{$time}')");
    
    $db->query("DELETE FROM Pokedex WHERE name = '{$mypokemon}'");
    
    print(json_encode([ 
        "success" => "Success! You have traded your {$mypokemon} for {$theirpokemon}!" 
    ]));
    
} catch (PDOException $pdoex) {
    header("HTTP/1.1 400 bad request");
    print(json_encode([ "error" => "Error: You have already found {$theirpokemon}." ]));
}

?>