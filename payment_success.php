<?php

session_start();
//if(!isset($_SESSION["userId"])){
	//link back to log in page as session is empty
//	header("location:signup_mock.php");
//}

if (isset($_GET["st"])){

	# code...
	    $trx_id = $_GET["tx"];
		$p_st = $_GET["st"];
		$amt = $_GET["amt"];
		$cc = $_GET["cc"];
		$cm_user_id = $_GET["cm"];
		//check if transaction is completed
	if ($p_st == "Completed") {

		include_once("includes/db.php");
		//select all data from cart by the user
		$sql = "SELECT `pId`,`quantity` FROM `cart` WHERE `uId` = '$cm_user_id'";
		$query = mysqli_query($conn,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["pId"];
			$qty[] = $row["quantity"];
			}

			//insert data from cart to orders
			for($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO `orders` (userId,productId,quantity,transactionId,orderStatus) VALUES ('$cm_user_id','".$product_id[$i]."','".$qty[$i]."','$trx_id','$p_st')";
				mysqli_query($conn,$sql);
			}

			//after insertion, drop the data in cart
			$sql = "DELETE FROM `cart` WHERE `uId` = '$cm_user_id'";
			if (mysqli_query($conn,$sql)) {
				?>
				<!--html to produce success-->
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset="UTF-8">
							<title>eMeal</title>
							<link rel="stylesheet" href="css/bootstrap.min.css"/>
							<script src="js/jquery2.js"></script>
							<script src="js/bootstrap.min.js"></script>
							<script src="main.js"></script>
							
						</head>
					<body>
						<div>
                            <form action="http://localhost/eMeal/shoppinggeneral.php" method="post">
                            <p>You have successfully paid</p>
                            <button name="submit" value="submit">Continue shopping</button>
                            </form> 
                        </div>
					</body>
					</html>

				<?php
			}
		}else{
			//empty data from cart therefore go back to shopping cart
			header("location:signup_mock.php?");
		}
		
	}
}



?>