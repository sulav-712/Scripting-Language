<?php

session_start();

$mysql = new mysqli("localhost", "root", "12345678", "practice");

if ($mysql->connect_error) {
  die ("Connection failed: " . $mysql->connect_error);
}
else {
  echo "Connected successfully";
}

$sql = "create table if not exists users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  PRIMARY KEY (id)
)";

if ($mysql->query($sql) === TRUE) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . $mysql->error;
}

$mysql->close();
?>