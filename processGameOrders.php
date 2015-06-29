<!-- 300160096 ChanhoLee processGameOrders.php-->
<?php
$memo = array();
$memo[0] = "";
$memo[1] = "";

include "cookie_info.php";

if(isset($_POST["chkout"]))
	{
		$myCon = mysqli_connect("localhost","root","","gamebuydb");
		if(mysqli_connect_errno())
		{
			printf("connection failed: %s\n",mysqli_connect_error());
		    exit();
		}
		else
		{
			if(isset($_POST["card"]) && $_POST["card"] != "")
			{
				$cid = $custData[0];
				$sql = "Delete From ordertbl Where ord_cust_id =".$cid;
				$res = mysqli_query($myCon, $sql);
				if($res)
				{
					if(mysqli_affected_rows($myCon) == 0)
					{
					$memo[0] = "<h2>Order has ALREADY been processed!!!<br />Please Close Your Browser To Exit.<br /></h2>";
					}
					else
					$memo[0] = "<h2>Thank You, Please Close Your Browser To Exit.<br /></h2>";
				}
			}
			else
			$memo[1] = "<h3>Please Press Browser Back Button And Re-Enter Your Credit Card Number</h3>";
			
		}
	}
	if(isset($_POST["btnlg"]))
		header("Location:gameBuyLogin.php");
	
		
?>
<html>
<head>
</head>
<body>
<div align="center">
	
	<h1>Game Buy</h1>
	<?php print "<h1>Order So Far for ".$custData[1]." ".$custData[2]."</h1>"; ?>
	
	<form method="POST" action="<?php print($_SERVER['PHP_SELF']); ?>">
	<?php 
			print $memo[1];
			print $memo[0];
			
			if($memo[0] != "")
			{
				
				print "<h1>Or <input type='submit' name='btnlg' value='Logout' /></h1>";
			}
	?>
	</form>
</div>
</body>
</html>
