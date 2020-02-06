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


<?php require "templates/header.html"; ?>

<?php
if (isset($_POST['submit'])) { 
    
    /* loop through returned results and place in tables */
    if ($result && $statement->rowCount() > 0) { ?>

    <script type='text/javascript'>alert('Please scroll down to view your results.');</script>

    <div class="my-4 p-3">

        <h5 class=" font-weight-bold py-2">Your Test Result</h5>

        <?php foreach ($result as $row) : ?>
     
        <table class="table table-sm table-borderless">

             <tr>
                <th class="">Candidate Number:</th>
                  <td><?php echo $row["cand_number"]; ?></td>
            </tr>
        </table>

        <table class="table table-bordered">

             <tr>
                <th class="">Overall Band</th>
                <td><?php echo $row["overall_band"]; ?></td>
             </tr>

             <tr>
                <th class="">Listening</th>
                <td><?php echo $row["listening"]; ?></td>
            </tr>

            <tr>
                <th class="">Reading</th>
                <td><?php echo $row["reading"]; ?></td>
            </tr>

            <tr>
                <th class="">Writing</th>
                <td><?php echo $row["writing"]; ?></td>
            </tr>

            <tr>
                <th class="">Speaking</th>
                <td><?php echo $row["speaking"]; ?></td>
            </tr>


        <?php endforeach; ?>

        </table>

        <p class="py-2"><span class="font-weight-bold">Disclaimer:</span> Please note that this results are provisional and should not be used as an official confirmation of your achievement. We will not accept any responsibility in the event you do so.
        </div>

        <?php } else { ?>  <!-- display an error if no match is found -->
       <script type='text/javascript'>alert('Sorry no match found for Candidate Number: <?php echo $_POST['cand_number']; ?>. Please verify and try again ');</script>

            <h6 class="mb-5">Sorry no match found for Candidate Number <strong class="text-danger"><?php echo $_POST['cand_number']; ?></strong>. Please verify and try again</h6>
            <?php }
           } ?>


<?php require "templates/footer.html"; ?>
