<?php

# Naruth Kongurai
# CSE 154
# Homework 7 - Pokedex 2
# Section: AO
# This is an update PHP file that replaces the existing name of a Pokemon with a new one as provided
# by the user. Successful and failure outputs are sent back as JSON data, while errors about
# parameters are returned as plain text message.

include "common.php";

// Ensures that the name and nickname parameters are passed and are not empty strings.
if (!(isset($_POST["name"]) 
        && isset($_POST["nickname"])) 
        || $_POST["name"] == "" 
        || $_POST["nickname"] == "") {
    header("HTTP/1.1 400 bad request");
    die(json_encode([ "error" => "Missing name and nickname parameters." ]));
}

$name = $_POST["name"];
$nickname = $_POST["nickname"];
$name_uppercase = strtoupper($nickname);

// Update the name using the new nickname provided
$result_set = $db->query(
    "UPDATE Pokedex 
    SET name = '{$nickname}', nickname = '{$name_uppercase}'
    WHERE name = '{$name}'");

$row_count = $result_set -> rowCount();       // Count the number of rows affected in MYSQL, 
if ($row_count == 0) {                       // Pokemon does not exist, didn't delete anything.
    header("HTTP/1.1 400 bad request");
    print(json_encode([ "error" => "Error: Pokemon {$name} not found in your Pokedex." ]));
} else {
    print(json_encode([ "success" => "Success! Your {$name} is now named {$nickname}!" ]));
}

?>