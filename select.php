<?php

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is a select PHP file that retrieves all Pokemon stored in the database and outputs them 
# as JSON.

include "common.php"; 
 
$result_set = $db->query("SELECT * FROM Pokedex");       # Retrieve all Pokemon in the database

$json_data = array("pokemon" => []);
foreach ($result_set as $row) {
    $pokemon_data = [
        "name" => $row["name"],
        "nickname" => $row["nickname"],
        "datefound" => $row["datefound"],
    ];
    array_push($json_data["pokemon"], $pokemon_data);      # Append Pokemon info into each array index
}

print(json_encode($json_data));

?>