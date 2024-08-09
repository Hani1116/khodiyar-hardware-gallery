<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

// fetch user details from order table
$fetch_user_address = mysqli_query($conn,"SELECT * FROM db.orders where user_id ='$user_id' order by id desc limit 1");

if(mysqli_num_rows($fetch_user_address)>0){
$user_data = mysqli_fetch_assoc($fetch_user_address);
$user_address=$user_data['address'];
$pic_code = substr($user_address,-6);
}
else{
// fetch user details from user table
$fetch_user_detail = mysqli_query($conn,"SELECT * from db.users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($fetch_user_detail);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>


   

<section class="checkout">

   <h1 class="heading">checkout summary</h1>

   <div class="row">

      <form action="pay.php" method="POST">


         <div>
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
               while ($row = mysqli_fetch_assoc($select_cart)) {

                  $cart_items[] = $row['name'] . ' (' . $row['price'] . ' x ' . $row['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($row['price'] * $row['quantity']);
            ?>
                 
            <?php
               }
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         </div>


         <h3>billing details</h3>
         <div class="flex">
            <div class="box">
               <p>Your name <span>*</span></p>
               <input type="text" name="name" required maxlength="50" value="<?= $user_data['name'] ?>" placeholder="Enter your name" class="input">
               
               <p>Your email <span>*</span></p>
               <input type="email" id="email" name="email" required value="<?= $user_data['email'] ?>" maxlength="50" placeholder="Enter your email" class="input">

               <p>Address line 02 <span>*</span></p>
               <input type="text" name="street" required maxlength="50" placeholder="e.g. Street name" class="input">

               <p>Pin code <span>*</span></p>
               <input type="text" name="pin_code" required maxlength="6" placeholder="e.g. 123456" value="<?php if(isset($pic_code)){ echo $pic_code ;} ?>" onkeypress="if(this.value.length == 6) return false;" class="input" min="0" max="999999">
         
            </div>
            <div class="box">
               <p>Mobile number <span>*</span></p>
               <input type="text" id="contact_number" name="number" required value="<?= $user_data['phone_no'] ?>" maxlength="10" placeholder="Enter your number" class="input" min="0" max="9999999999">

               <p>Address line 01 <span>*</span></p>
               <input type="text" name="flat" required maxlength="50" placeholder="e.g. Flat & building number" class="input">

               <p>Area <span>*</span></p>
               <input type="text" name="city" required maxlength="50" placeholder="e.g. Nikol" class="input">
          </div>
         </div>
         <input type="submit" id="submit_button" value="Continues" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
      </form>

      <div class="summary">
         <h3 class="title">cart items</h3>
         <?php
          
               $select_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");
               if(mysqli_num_rows($select_cart) > 0){
                  while($fetch_cart = mysqli_fetch_assoc($select_cart)){        
         ?>
         <div class="flex">
            <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="image" alt="">
            <div>
               <h3 class="name"><?= $fetch_cart['name']; ?></h3>
               <p class="price">₹<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></p>
            </div>
         </div>
         <?php
                  }
               }else{
                  echo '<p class="empty">your cart is empty</p>';
               }
         ?>
         <div class="grand-total"><span>Grand total :</span><p><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></p></div>
      </div>

   </div>

</section>   

   <?php include 'components/footer.php'; ?>
   <!-- <script src="js/script.js"></script> -->
   <script src="js/checkout_validation.js"></script>
</body>

</html>