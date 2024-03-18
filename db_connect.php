 
 <?php

    /*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Assignment 3 - Blogging Application

     ****************/

    define('DB_DSN', 'mysql:host=localhost;dbname=runoutloudserver;charset=utf8');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);

    try {
        // Try creating new PDO connection to MySQL.
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS, $option);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    } catch (PDOException $e) {
        echo "Failed To Connect : " . $e->getMessage();
        die(); // Force execution to stop on errors.
        // When deploying to production you should handle this
        // situation more gracefully. ¯\_(ツ)_/¯
    }
    ?>