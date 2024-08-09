<?php

include 'components/connect.php';
session_start();

$user_id = $_SESSION['user_id'];
$order_id = $_GET['id'];

$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("Y-m-d", $TodayDate);

$sql = mysqli_query($conn, "SELECT * FROM db.orders WHERE user_id = '$user_id' AND id = '$order_id' ");

$sql2 = mysqli_query($conn, "SELECT * FROM db.order_items where order_id = '$order_id'");
$row = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Download Invoice</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo"><img src="project images/Khodiyar_gallery.png" alt="Logo"></div>
            </div>
            <div class="tm_invoice_right">
              <div class="tm_grid_row tm_col_3">
                <div>
                  <b class="tm_primary_color">Email</b> <br>
                  jigar.amarkotiya@gmail.com
                </div>
                <div>
                  <b class="tm_primary_color">Phone</b> <br>
                  +91 9558015905<br>
                </div>
                <div>
                  <b class="tm_primary_color">Address</b> <br>
                  Khodiyar Furniture <br> 
                  Nr.Safal-7, Soni Ni Chali <br>
                  Ahemedabad-380023
                </div>
              </div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb10">
            <div class="tm_invoice_info_left">
              <p class="tm_mb2"><b>Bill To:</b></p>
              <p>
                <b class="tm_f16 tm_primary_color"><?= $row['name']  ?></b> <br>
                <?= $row['address']  ?><br>
                <?= $row['phone_no'] ?>
              </p>
            </div>
            <div class="tm_invoice_info_right">
              <div class="tm_ternary_color tm_f50 tm_text_uppercase tm_text_center tm_invoice_title tm_mb15 tm_mobile_hide">Invoice</div>
              <div class="tm_grid_row tm_col_3 tm_invoice_info_in tm_gray_bg tm_round_border">
                <div>
                  <span>Customer ID:</span> <br>
                  <b class="tm_primary_color"><?= $user_id  ?></b>
                </div>
                <div>
                  <span>Invoice Date:</span> <br>
                  <b class="tm_primary_color"><?= $Date  ?></b>
                </div>
                <div>
                  <span>Invoice No:</span> <br>
                  <b class="tm_primary_color"><?= $row['id']  ?></b>
                </div>
              </div>
            </div>
          </div>
          <div class="tm_table tm_style1">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_7 tm_semi_bold tm_primary_color">Item Details</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color">Price</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color">Quantity</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_text_right">Total</th>
                    </tr>
                  </thead>
                  <tbody><?php while($list = mysqli_fetch_assoc($sql2)){ ?>
                    <tr>
                      <td class="tm_width_7">
                        <?= $list['product_name'] ?>
                      </td>
                      <td class="tm_width_2">₹<?= $list['product_price'] ?></td>
                      <td class="tm_width_1 tm_text_center"><?= $list['quantity'] ?></td>
                      <td class="tm_width_2 tm_text_right">₹<?= ($list['product_price'] * $list['quantity']) ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer">
              <div class="tm_left_footer">
                <p class="tm_mb2"><b class="tm_primary_color">Payment info : </b><?= $row['transaction_id'] ?></p>
                <p class="tm_m0">Name : <?= $row['name'] ?><br>
				<p class="tm_m0">Place on : <?= $row['placed_on'] ?><br>
              </div>
              <div class="tm_right_footer">
                <table>
                  <tbody>
                    <tr>
                      <td class="tm_width_2 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_accent_bg tm_radius_6_0_0_6">Grand Total	</td>
                      <td class="tm_width_2 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right tm_white_color tm_accent_bg tm_radius_0_6_6_0">₹<?= $row['total_price'] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24" fill='currentColor'/></svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>  
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jspdf.min.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>