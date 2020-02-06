<?php

require "config.php";

/* get information form database based on query */
try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM marks";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Admin - Update</title>

	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>

<div class= "container-fluid p-5">
<h2 class="my-5 text-primary"><strong>Update items</strong></h2>

<table class="table">
    <thead>
        <tr>
          <th>id</th>
          <th>Candidate Number</th>
          <th>Test Date</th>
          <th>DOB</th>
          <th>IDN</th>
          <th>Overall Band</th>
          <th>Listening</th>
          <th>Reading</th>
          <th>Writing</th>
          <th>Speaking</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?> <!-- loop through information and display them in table -->
        <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo $row["cand_number"]; ?></td>
          <td><?php echo $row["test_date"]; ?></td>
          <td><?php echo $row["DOB"]; ?></td>
          <td><?php echo $row["IDN"]; ?></td>
          <td><?php echo $row["overall_band"]; ?></td>
          <td><?php echo $row["listening"]; ?></td>
          <td><?php echo $row["reading"]; ?></td>
          <td><?php echo $row["writing"]; ?></td>
          <td><?php echo $row["speaking"]; ?></td>
        <td><a class = "btn btn-success px-4 py-1" href="update-single.php?id=<?php echo $row["id"]; ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a class = "btn btn-danger btn-lg w-25 my-3" href="index.php">menu</a> <!-- back to main menu -->

</body>
</html>