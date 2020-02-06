<?php
/* create db connection  */
require "config.php";


if (isset($_POST['submit'])) { /* extract user data sent in form */

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "id"           => $_POST['id'],
      "cand_number"  => $_POST['cand_number'],
      "test_date"    => $_POST['test_date'],
      "DOB"          => $_POST['DOB'],
      "IDN"          => $_POST['IDN'],
      "overall_band" => $_POST['overall_band'],
      "listening"    => $_POST['listening'],
      "reading"      => $_POST['reading'],
      "writing"      => $_POST['writing'],
      "speaking"     => $_POST['speaking']
    ];

    /*edit the selected user based on their id */
    $sql = "UPDATE marks
            SET id = :id,
                cand_number = :cand_number,
                overall_band = :overall_band,
                test_date  = :test_date,
                DOB = :DOB,
                IDN = :IDN,
                listening = :listening,
                reading = :reading,
                writing = :writing,
                speaking= :speaking
            WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM marks WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Could not modify an error occurred";
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Update single</title>

	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>

<div class= "container">
	<h2 class="my-5 text-primary"><strong>Edit item</strong></h2>

<?php if (isset($_POST['submit']) && $statement) : ?><!-- feedback based on form status -->
      <h4 class="mb-5 text-success">success Candidate <strong class=""><?php echo $_POST['cand_number']; ?></strong> updated!!!</h4>
<?php endif; ?>

<form class="form w-50" method="post">

    <?php foreach ($user as $key => $value) : ?><!-- loop through user data and place them accordingly -->

    <div class="form-group">
      <label class="h4" for="<?php echo $key; ?>"><strong><?php echo ucfirst($key); ?></strong></label>
	    <input class="form-control form-control-lg" type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
   </div>
    <?php endforeach; ?>
  <input class="btn btn-primary btn-lg w-100" type="submit" name="submit" value="update" data-toggle="modal" data-target="#exampleModal">
</form>


  <a class = "btn btn-danger btn-lg w-25 my-3" href="index.php">menu</a>
  </div>
</body>
</html>
