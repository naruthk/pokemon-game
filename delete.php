<?php

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is a delete PHP file that allows the user to remove a single Pokemon or an entire collection
# of Pokemon that the user has stored in the database so far. Successful and failure outputs are 
# sent back as JSON data.

include "common.php"; 

// Check to see if user has type in a mode.
if (isset($_POST["mode"])) {
    
    $mode = $_POST["mode"];
    
    // Delete all Pokemon in the database if mode is "removeall"
    if ($mode == "removeall") {
        $db->query("DELETE FROM Pokedex;");
        die(json_encode([ "success" => "Success! All Pokemon removed from your Pokedex!" ]));
        
    } else {
        header("HTTP/1.1 400 bad request");
        die(json_encode([ "error" => "Error: Unknown mode {$mode}." ]));
    }
}

// Ensures that the name parameter is passed. Checks if the name parameter is an empty string
if (!isset($_POST["name"]) || $_POST["name"] == "") {
    header("HTTP/1.1 400 bad request");
    die(json_encode([ "error" => "Missing name parameter." ]));
}

// Delete a Pokemon based on the POST name.
$name = $_POST["name"];
$result_set = $db->query("DELETE FROM Pokedex WHERE name = '{$name}'");

$row_count = $result_set -> rowCount();       // Count the number of rows affected in MYSQL, 
if ($row_count == 0) {                       // Pokemon does not exist, didn't delete anything.
    header("HTTP/1.1 400 bad request");
    print(json_encode([ "error" => "Error: Pokemon {$name} not found in your Pokedex." ]));
} else {
    print(json_encode([ "success" => "Success! Pokemon {$name} removed from your Pokedex!" ]));
}

?>