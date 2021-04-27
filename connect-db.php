<?php
/* Kevin Dang kd9me - Jennifer Huynh jph5au */

$hostname = 'localhost:3306';     
$dbname = 'guestbook';
$username = 'kd4640';
$password = 'pwd4640';

$dsn = "mysql:host=$hostname;dbname=$dbname";

try 
{
   $db = new PDO($dsn, $username, $password);
}
catch (PDOException $e) 
{

   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)  
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>