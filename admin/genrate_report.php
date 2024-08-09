<?php

include '../vendor/autoload.php';
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$report_type = $_POST['report_name'];
}

// ********************PAYMENT REPORT**************************
if($report_type == 'payment'){
$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("d-m-Y", $TodayDate);

$sql1 = mysqli_query($conn, "SELECT * FROM db.orders WHERE placed_on between '$date1' AND '$date2' ");

$html = '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Download Invoice</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title">
									<img src="../project images/Khodiyar_gallery.png" style="width: 90%; max-width: 160px" />
								</td>
								
								
								<td style="width:40% text-align:right;" >
									<h2> Payment Report </h2>
									<b>Created Report :</b> '.$Date.'<br>
									<b>From :</b> '.$date1.'<br>
									<b>To   :</b> '.$date2.'
								</td>
							</tr>
						</table>
					</td>
				</tr>

	
				


				<tr class="heading">
					<td style="width: 6%;" >Id</td>
					<td style="text-align:left; width: 30%;">Name</td>
					<td style="text-align:left; width: 30%;">Transaction_id</td>
					<td style="width: 20%;text-align:center;">Placed_on</td>
					<td style="width: 21%;text-align:right;">Delivery Status</td>
					<td style="width: 10%;text-align:right;">Price</td>
				</tr>';

				$total_price = 0;
				while($list = mysqli_fetch_assoc($sql1)){
				$html.= '<tr class="item">
					<td style="width: 6%;" >'.$list['id'].'</td>
					<td style="width: 30%; text-align:left;">'.$list['name']. '</td>
					<td style="width: 30%; text-align:left;">'.$list['transaction_id'].'</td>
					<td style="width: 20%; text-align:center;">'.$list['placed_on'].'</td>
					<td style="width: 20%; text-align:center;">'.$list['delivery_status'].'</td>
					<td style="width: 10%;text-align:right;">₹'.$list['total_price'] .'</td>';
					$total_price+=$list['total_price'];
				'</tr>';
				}



$html.= '<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right; width: 20%;"><b>Total:₹' . $total_price . '</b> </td>
				</tr>';

$html .= '</table>
		</div>
	</body>
</html>';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);
$mpdf->Output();
}




// *************STOCK REPORT*******************
if($report_type == 'stock'){
$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("d-m-Y", $TodayDate);

$sql1 = mysqli_query($conn, "SELECT * FROM db.products order by id asc");

$html = '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Download Invoice</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title">
									<img src="../project images/Khodiyar_gallery.png" style="width: 90%; max-width: 160px" />
								</td>
								
								
								<td style="width:40% text-align:right;" >
									<h2> Stock Report </h2> 
									<b>Created Report :</b> '.$Date.'<br>
								</td>
							</tr>
						</table>
					</td>
				</tr>

	
				


				<tr class="heading">
					<td style="width: 6%;" >Id</td>
					<td style="text-align:left; width: 60%;">Product Name</td>
					<td style="text-align:center; width: 15%;">Category</td>
					<td style="width: 10%;text-align:center;">Price</td>
					<td style="width: 10%;text-align:center;">Stock</td>
					<td style="width: 10%;text-align:right;">Sub Total</td>
				</tr>';

				$total_price = 0;
				$no = 1;
				while($list = mysqli_fetch_assoc($sql1)){
				$html.= '<tr class="item">
					<td style="width: 6%;" >'.$no.	'</td>
					<td style="width: 60%; text-align:left;">'.$list['name']. '</td>
					<td style="width: 15%; text-align:center;">'.$list['keyword'].'</td>
					<td style="width: 10%; text-align:center;">₹'.$list['price'].'</td>
					<td style="width: 10%; text-align:center;">'.$list['stock'].'</td>
					<td style="width: 10%;text-align:right;">₹'.( $list['price'] * $list['stock']).'</td>';
					$total_price += ($list['price'] * $list['stock']);
					$no+=1;
				'</tr>';
				}


$html.= '<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right; width: 20%;"><b>Total:₹' . $total_price . '</b> </td>
				</tr>';

$html .= '</table>
		</div>
	</body>
</html>';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);
$mpdf->Output();
}



// *************SALES REPORT*******************
if($report_type == 'sales'){
$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("d-m-Y", $TodayDate);

// $sql1 = mysqli_query($conn, "SELECT * FROM db.order_items order by id asc");
$sql1 = mysqli_query($conn, "SELECT order_id,product_name,pid,quantity,product_price,sum(quantity) as total_sell from db.order_items group by pid order by total_sell desc");

$html = '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Download Invoice</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title">
									<img src="../project images/Khodiyar_gallery.png" style="width: 90%; max-width: 160px" />
								</td>
								
								
								<td style="width:40% text-align:right;" >
									<h2>Sales Report</h2>
									<b>Created on :</b> '.$Date.'<br>
								</td>
							</tr>
						</table>
					</td>
				</tr>

	
				


				<tr class="heading">
					<td style="width: 6%;" >No.</td>
					<td style="text-align:left; width: 60%;">Product Name</td>
					<td style="width: 10%;text-align:center;">Price</td>
					<td style="width: 20%;text-align:center;">Total Sell</td>
					<td style="width: 8%;text-align:right;">Sub Total</td>
				</tr>';

				$total_price = 0;
				$no = 1;
				while($list = mysqli_fetch_assoc($sql1)){
				$html.= '<tr class="item">
					<td style="width: 6%;" >'.$no.	'</td>
					<td style="width: 60%; text-align:left;">'.$list['product_name']. '</td>
					<td style="width: 10%; text-align:center;">₹'.$list['product_price'].'</td>
					<td style="width: 20%; text-align:center;">'.$list['total_sell'].'</td>
					<td style="width: 8%;text-align:right;">₹'.( $list['product_price'] * $list['total_sell']).'</td>';
					$total_price += ($list['product_price'] * $list['total_sell']);
					$no+=1;
				'</tr>';
				}


$html.= '<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right; width: 20%;"><b>Total:₹' . $total_price . '</b> </td>
				</tr>';

$html .= '</table>
		</div>
	</body>
</html>';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);
$mpdf->Output();
}
?>




