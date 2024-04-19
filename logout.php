<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
    Description: Logout function

 ****************/
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
