<?php
/* create database connection  */
$host       = "localhost";
$username   = "phpmyadmin";
$password   = "phpmyadmin";
$dbname     = "test";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

if (isset($_POST['submit'])) { /* check for form submission */

  try  { /* fetch information from database */
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM marks
            WHERE cand_number = :cand_number";

    $cand_number = $_POST['cand_number'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':cand_number', $cand_number, PDO::PARAM_STR);
    $statement->execute();

    /* return results of querry back here */
    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<!-- markup to display output -->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Admin - Read</title>

	<link rel="stylesheet" href="../css/bootstrap.css"> 
</head>
<body>

<div class= "container">
	<h2 class="my-5 text-primary"><strong>Read items</strong></h2>


<?php
if (isset($_POST['submit'])) { /* loop through returned results and place in tables */
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>search results </h2>

    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>Candidate Number</th>
          <th>Overall Band</th>
          <th>Listening</th>
          <th>Reading</th>
          <th>Writing</th>
          <th>Speaking</th>

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



        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>  <!-- display an error if no match is found -->
      <h4 class="mb-5">Sorry no match for <strong class="text-danger"><?php echo $_POST['cand_number']; ?></strong></h4>
    <?php }
} ?>

<!-- form used to collect information to be searched -->
<form class="form w-50" method="post">
<div class="form-group">
  <label class="h4" for="cand_number"><strong>Candidate Number</strong></label>
  <input class="form-control form-control-lg" type="text" id="cand_number" name="cand_number">
  </div>
  <input class="btn btn-primary btn-lg w-100" type="submit" name="submit" value="search">
</form>
  <a class = "btn btn-danger btn-lg w-25 my-3" href="index.php">menu</a>


</div>
</body>
</html>