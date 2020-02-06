<?php

/* setting up connection to database  using PDO php data object*/
$host       = "localhost";
$username   = "phpmyadmin";
$password   = "phpmyadmin";
$dbname     = "test";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

/* check for a submitted for using a try catch err block standard php rules */
if (isset($_POST["submit"])) {

  try {
    $connection = new PDO($dsn, $username, $password, $options); //create connection to db using predefined variables above
  
    $id = $_POST["submit"]; //extract id from submitted form data

    $sql = "DELETE FROM marks WHERE id = :id";  //sql query to delete item based on its id

    $statement = $connection->prepare($sql);  //sending the sql statement to the database through a PDO connection
    $statement->bindValue(':id', $id);
    $statement->execute();

  } catch(PDOException $error) {  /* catch any errors that occur and display them */
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {

   /* on successful connection to database return all records in it */

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM marks";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<!-- html code to be processed by php 
     all elements styled using bootstrap -->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Delete</title>

	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>

<div class= "container">
<h2 class="my-5 text-primary"><strong>Delete items</strong></h2>

 <?php if (isset($_POST['submit']) && $statement) : ?>
    <h4 class="mb-5">Success Candidate <strong class="text-danger"><?php echo $_POST['submit']; ?></strong> Has been deleted.</h4>
  <?php endif; ?>



<form class="form" method="post"> <!-- wrap form with table -->
  <table class="table ">
    <thead>
      <tr>
         <th>id</th>
          <th>Candidate Number</th>
          <th>Overall Band</th>
          <th>Listening</th>
          <th>Reading</th>
          <th>Writing</th>
          <th>Speaking</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo $row["cand_number"]; ?></td>
          <td><?php echo $row["overall_band"]; ?></td>
          <td><?php echo $row["listening"]; ?></td>
          <td><?php echo $row["reading"]; ?></td>
          <td><?php echo $row["writing"]; ?></td>
          <td><?php echo $row["speaking"]; ?></td>
        <td><button class = "btn btn-danger px-4 py-1" type="submit" name="submit" value="<?php echo $row["id"]; ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

  <a class = "btn btn-danger btn-lg w-25 my-3" href="index.php">menu</a> <!-- nav button to return to main menu -->


</body>
</html>