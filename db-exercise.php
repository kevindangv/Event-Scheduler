<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
  
  <title>PHP and MySQL database</title>    
</head>
<body>
  
  <div class="container">
    <h1>PHP and MySQL database</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
      <input type="submit" name="btnaction" value="create" class="btn btn-light" />
      <input type="submit" name="btnaction" value="insert" class="btn btn-light" />   
      <input type="submit" name="btnaction" value="select" class="btn btn-light" />
      <input type="submit" name="btnaction" value="update" class="btn btn-light" />
      <input type="submit" name="btnaction" value="delete" class="btn btn-light" />
      <input type="submit" name="btnaction" value="drop" class="btn btn-light" />            
    </form>


<?php
require('connect-db.php');

// require: if a required file is not found, require() produces a fatal error, the rest of the script won't run
// include: if a required file is not found, include() throws a warning, the rest of the script will run
?>

<?php 
if (isset($_GET['btnaction']))
{	
   try 
   { 	
      switch ($_GET['btnaction']) 
      {
         case 'create': createTable(); break;
         case 'insert': insertData();  break;
         case 'select': selectData();  break;
         case 'update': updateData();  break;
         case 'delete': deleteData();  break;
         case 'drop':   dropTable();   break;      
      }
   }
   catch (Exception $e)       // handle any type of exception
   {
      $error_message = $e->getMessage();
      echo "<p>Error message: $error_message </p>";
   }   
}
?>

<?php 
/*************************/
/** create table **/
function createTable()
{
 
	
	
	
	
	
	
	
	
	
}
?>

<?php 
/*************************/
/** drop table **/
function dropTable()
{
  
	
	
	
	
	
	
	
	
}
?>

<?php 
/*************************/
/** insert data **/
function insertData()
{
   
	
	
	
	
	
	
	
	
}
?>

<?php  
/*************************/
/** get data **/
function selectData()
{

	
	
	
	
	
	
	
	
	
}
?>

<?php
/*************************/
/** update data **/
function updateData()
{
  
	
	
	
	
	
	
	
	
	
}
?>

<?php
/*************************/
/** delete data **/
function deleteData()
{
	
	
	
	
	
	
	
	
	
	
}
?>


  </div>
</body>
</html>