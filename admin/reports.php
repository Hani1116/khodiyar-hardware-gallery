<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
   header('location:login.php');
};

if(isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_message = mysqli_query($conn, "DELETE FROM db.messages WHERE id = '$delete_id' ");
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Generate Reports</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="contacts">

      <h1 class="heading">Generate Reports</h1>
      
<section class="report-container">

   <form action="genrate_report.php" method="post" class="login">

      <div class="inputBox">
               <select name="report_name" class="box" id="report" required>
                     <option value="" selected>Select Report</option>
                     <option value ='sales'> Sales Report </option>
                     <option value ='payment'> Payment Report </option>
                     <option value ='stock'> Stock Report </option>
               </select>
      </div>
      <div class="hidden dates">
      <p>Select first date</p>
      <input type="date" name="date1" id="start-date" class="box" min="2023-01-01">
      <p>Select second date</p>
      <input type="date" name="date2" id="end-date" class="box" min="2023-01-01">
      </div>
      <input type="submit" name="submit" value="Generate now" id="submit-btn" class="btn">
   </form>

</section>

</section>

<script src="../js/admin_script.js"></script>

</body>

</html>
