<?php

include 'components/connect.php';


if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

$grand_total = $_SESSION['total_price'];

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

   <div class="row" style="width: fit-content;margin: auto;">

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
               }
         ?>
         <div class="grand-total"><span>Grand total :</span><p><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></p></div>
         <input type="submit" id="rzp-button1" value="Checkout"  class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
      </div>

   </div>

</section>   

</body>

</html>

<!-- <button id="rzp-button1">Pay</button> -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="verify.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>