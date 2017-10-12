-- Naruth Kongurai
-- Section AO. CSE 154
-- This is a simple SQL script that creates a table called Pokedex that stores 
-- the basic information for the Pokedex game, including name, nickname, and 
-- date that each Pokemon is found.

CREATE TABLE Pokedex(
  name VARCHAR(20) NOT NULL PRIMARY KEY 
  ,nickname    VARCHAR(20) NOT NULL
  ,datefound    DATETIME NOT NULL
);