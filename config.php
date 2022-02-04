<?php

$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "demo";


$link = new mysqli($server_name, $username, $password);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($link->query($sql) === FALSE)
    echo "Error creating database: " . $link->error;

$link = new mysqli($server_name, $username, $password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// ---------- Creation tables ----------
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($link->query($sql) === FALSE)
    echo "Error creating users table: " . $link->error;

$sql_announcements = "CREATE TABLE IF NOT EXISTS announcements (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    project VARCHAR(255) NOT NULL,
    maintext VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($link->query($sql_announcements) === FALSE)
    echo "Error creating announcements table: " . $link->error;

$sql_documents = "CREATE TABLE IF NOT EXISTS documents (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    name_position_file VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($link->query($sql_documents) === FALSE)
    echo "Error creating announcements table: " . $link->error;

$sql_projects = "CREATE TABLE IF NOT EXISTS projects (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    goals VARCHAR(255) NOT NULL,
    pronunciation VARCHAR(255) NOT NULL,
    deliverable VARCHAR(255) NOT NULL,
    deliverable_date VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($link->query($sql_projects) === FALSE)
    echo "Error creating announcements table: " . $link->error;


$db = mysqli_connect($server_name, $username, $password, $db_name);
