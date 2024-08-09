<?php

include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['name'];

if (!isset($admin_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
            <h3>Welcome!</h3>
            <p><?= $admin_name ?></p>
            <a href="update_profile.php" class="btn">Update profile</a>
         </div>

      <div class="box">
            <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM db.orders WHERE payment_status = 'completed' ");
            if (mysqli_num_rows($select_completes) > 0) {
               while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
                  $total_completes += $fetch_completes['total_price'];
               }
            }
            ?>
            <h3>₹<?= $total_completes; ?><span>/-</span></h3>
            <p>Completed orders</p>
            <a href="placed_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM db.orders WHERE delivery_status = 'completed'  ");
            $number_of_orders = mysqli_num_rows($select_orders);
            $row = mysqli_fetch_assoc($select_orders);
            ?>
            <h3><?= $number_of_orders; ?></h3>
            <p>Orders placed</p>
            <a href="placed_orders.php?delivery_status=completed" class="btn">See orders</a>
         </div>

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM db.orders WHERE delivery_status = 'in progress' ");
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?= $number_of_orders; ?></h3>
            <p>Orders in progress</p>
            <a href="placed_orders.php?delivery_status=in progress" class="btn">See orders</a>
         </div>

         <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM db.products");
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?= $number_of_products; ?></h3>
            <p>Products added</p>
            <a href="products.php" class="btn">See products</a>
         </div>

         <div class="box">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM db.users ");
            $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>Normal users</p>
            <a href="users_accounts.php" class="btn">See users</a>
         </div>

         <div class="box">
            <?php
            $select_admins = mysqli_query($conn, "SELECT * FROM db.admins ");
            $number_of_admins = mysqli_num_rows($select_admins);
            ?>
            <h3><?= $number_of_admins; ?></h3>
            <p>Admin users</p>
            <a href="admin_accounts.php" class="btn">See admins</a>
         </div>

         <div class="box">
            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM db.messages ");
            $number_of_messages = mysqli_num_rows($select_messages)
            ?>
            <h3><?= $number_of_messages; ?></h3>
            <p>New messages</p>
            <a href="messages.php" class="btn">See messages</a>
         </div>

   </div>

</section>

<section class="display-product-table">

   <h1 class="heading" style="color: green;">Top selling products</h1>

   <table>

         <thead>
            <th style="width: 100px;">No.</th>
            <th>Product name</th>
            <th style="width: 200px;">Total Sell</th>
            <th style="width: 180px;">Product Price</th>
            <th style="width: 150px;">Action</th>
         </thead>

         <tbody>
            <?php

            $no = 1;
            $select_top_sell = mysqli_query($conn, " SELECT order_id,product_name,pid,quantity,product_price,sum(quantity) as total_sell from db.order_items group by pid order by total_sell desc limit 5");
            if (mysqli_num_rows($select_top_sell) > 0) {
               while ($list = mysqli_fetch_assoc($select_top_sell)) {
            ?>

                  <tr>
                     <td><?= $no ?></td>
                     <td><?= $list['product_name']; ?></td>
                     <td><?= $list['total_sell']; ?></td>
                     <td><span>₹<?= $list['product_price']; ?></span>/-</td>
                  
                  <td>
                        <a href="update_product.php?update=<?= $list['pid']; ?>" class="option-btn" ></i> View </a>
                  </td>
               </tr>
            <?php
               $no+=1;
               };
            }
            ?>
         </tbody>
      </table>

</section>

<section class="display-product-table">

   <h1 class="heading" style="color: red;" >Stock Report</h1>

   <table>

         <thead>
            <th style="width: 100px;">No.</th>
            <th>Product name</th>
            <th style="width: 200px;">Stock</th>
            <th style="width: 180px;">Product Price</th>
            <th style="width: 150px;">Action</th>
         </thead>

         <tbody>
            <?php

            $no = 1;
            $select_top_sell = mysqli_query($conn, "SELECT * from db.products order by stock limit 5");
            if (mysqli_num_rows($select_top_sell) > 0) {
               while ($list = mysqli_fetch_assoc($select_top_sell)) {
            ?>

                  <tr>
                     <td><?= $no ?></td>
                     <td><?= $list['name']; ?></td>
                     <?php if($list['stock'] <= 5){ ?>
                     <td><span style="color:red;"><?= $list['stock']; ?><span></td>
                     <?php }else{ ?>
                     <td><?= $list['stock']; ?></td>
                     <?php } ?>
                     <td><span>₹<?= $list['price']; ?></span>/-</td>
                  
                  <td>
                        <a href="update_product.php?update=<?= $list['id']; ?>" class="option-btn" ></i> Update </a>
                  </td>
               </tr>
            <?php
               $no+=1;
               };
            }
            ?>
         </tbody>
      </table>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>