<?php

/* create database connection  */
require "../admin/config.php";

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
    <?php foreach ($result as $row) : ?>

        <div class="col-md-7 col-sm-12  p-3 ">
        <script type='text/javascript'>alert('Please scroll down to view your results.');</script>

        <h5 class=" font-weight-bold py-2">Your Test Result</h5>

        <table class=" table table-borderless">

             <tr>
                <th class="">Candidate Number:</th>
                  <td class=""><?php echo $row["cand_number"]; ?></td>
            </tr>
        </table>

        <table class="table-sm table-bordered">

             <tr>
                <th class="px-4 py-2">Overall Band</th>
                <td class="px-3 py-2"><?php echo $row["overall_band"]; ?></td>
             </tr>

             <tr>
                <th class="px-4 py-2">Listening</th>
                <td class="px-3 py-2"><?php echo $row["listening"]; ?></td>
            </tr>

            <tr>
                <th class="px-4 py-2">Reading</th>
                <td class="px-3 py-2"><?php echo $row["reading"]; ?></td>
            </tr>

            <tr>
                <th class="px-4 py-2">Writing</th>
                <td class="px-3 py-2"><?php echo $row["writing"]; ?></td>
            </tr>

            <tr>
                <th class="px-4 py-2">Speaking</th>
                <td class="px-3 py-2"><?php echo $row["speaking"]; ?></td>
            </tr>

        </table>
        </div>

     <?php endforeach; ?>

     <p class="p-4"><span class="font-weight-bold">Disclaimer:</span>Please note that this online result is provisional and should not be used as an official official confirmation of your achievement.British council will not accept any responsibility in the event that your result fails to display here or for any error in your online results,wether due to a technical fault or administrative procedure.</p>


    <?php } else { ?>

          <!-- display an error if no match is found -->
          <div class="col-md-8 col-sm-8  p-3 ">
        <script type='text/javascript'>alert('Sorry no match found for Candidate Number: <?php echo $_POST['cand_number']; ?>. Please verify and try again ');</script>
            <h6 class="mb-5">Sorry no match found for Candidate Number <strong class="text-danger"><?php echo $_POST['cand_number']; ?></strong>. Please verify and try again</h6>
        </div>

    <?php }
    } ?>

</div>

<?php require "templates/footer.html"; ?>
