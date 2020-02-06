<?php
/* setup database connection */
$host       = "localhost";
$username   = "phpmyadmin";
$password   = "phpmyadmin";
$dbname     = "test";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );


if (isset($_POST['submit'])) { /* check to see if any form has been submitted */

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    /*fill the data acquired into an array */
    $new_user = array(
      /*"id"           => $_POST['id'],*/
      "cand_number"  => $_POST['cand_number'],
      "overall_band" => $_POST['overall_band'],
      "listening"    => $_POST['listening'],
      "reading"      => $_POST['reading'],
      "writing"      => $_POST['writing'],
      "speaking"     => $_POST['speaking']
    );

   /* use sprintf function to piece query together due to issues with php 7 php version */
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "marks",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );

    $statement = $connection->prepare($sql);
    $statement-> execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

?>

<!-- html markup -->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Admin - Create</title>

	<link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>
<div class= "container">
	<h2 class="my-5 text-primary"><strong>Create New item</strong></h2>

 <!-- alert message for status of form submission -->
  <?php if (isset($_POST['submit']) && $statement) : ?>
    <h4 class="mb-5">Candidate <strong class="text-success"><?php echo $_POST['cand_number']; ?></strong> Has been added to Database.</h4>
  <?php endif; ?>

  <form class="form w-50" method="post">
   <div class="form-group">
    <input class="form-control form-control-lg" type="hidden" name="id" id="id">
    </div>

    <div class="form-group">
    <label class="h5 font-weight-bold" for="cand_number">Candidate Number</label>
    <input class="form-control form-control-lg" type="text" name="cand_number" id="cand_number">
    </div>

    <div class="form-group">
    <label class="h5 font-weight-bold" for="overall_band">Overall Band</label>
    <input class="form-control form-control-lg" type="text" name="overall_band" id="overall_band">
    </div>

    <div class="form-group">
    <label class="h5 font-weight-bold" for="listening">Listening</label>
    <input class="form-control form-control-lg" type="text" name="listening" id="listening">
    </div>

    <div class="form-group">
    <label class="h5 font-weight-bold" for="reading">Reading</label>
    <input class="form-control form-control-lg" type="text" name="reading" id="reading">
    </div>

    <div class="form-group">
    <label class="h5 font-weight-bold" for="writing">Writing</label>
    <input class="form-control form-control-lg" type="text" name="writing" id="writing">
    </div>
    <div class="form-group">
    <label class="h5 font-weight-bold" for="speaking">Speaking</label>
    <input class="form-control form-control-lg" type="text" name="speaking" id="speaking">
    </div>

    <input class="btn btn-primary btn-lg w-100" type="submit" name="submit" value="create">
  </form>

  <a class = "btn btn-danger btn-lg w-25 my-3" href="index.php">menu</a>
  </div>
</body>

</html>
