<!--  300160096 Chanho Lee addOrderGame.php -->
<?php
include "cookie_info.php";
	$qty = "";
	$total = "";
	
	switch($_POST["qty"])
		{
			case '1':
				$qty = 1;
				break;
				
			case '2':
				$qty = 2;
				break;
			case '3':
				$qty = 3;
				break;
			case '4':
				$qty = 4;
				break;
			case '5':
				$qty = 5;
				break;
				
			
		} 
		

if($_POST["submit"])
	{
		$memo = array();
		$memo[0] = "";
		$memo[1] = "";
		$cid = $custData[0];
		$ord_GID = array();
		
						
			
			
			
			$myCon = mysqli_connect("localhost","root","","gamebuydb");
			if(mysqli_connect_errno())
			{
				printf("connection failed: %s\n",mysqli_connect_error());
			    exit();
			}
			else
			{
				$sql = "Select ord_gme_id from ordertbl where ord_cust_id =".$cid;
				$res = mysqli_query($myCon, $sql);
				$num = mysqli_num_rows($res);
				
				if($num > 0)
				{
					for($row = 1; $row <= mysqli_num_rows($res); $row++)
					{
						$record = mysqli_fetch_array($res);
						$ord_GID[$row] = $record["ord_gme_id"];
					}
				}
			}
		
			
			
			
		if(isset($_POST["addToCart"]))
			{
				$myCon = mysqli_connect("localhost","root","","gamebuydb");
				if(mysqli_connect_errno())
				{
					printf("connection failed: %s\n",mysqli_connect_error());
				    exit();
				}
				else
				{
					
					$addToCart = array();
					if(sizeof($ord_GID) > 0)
					{
						$temp = array_diff($_POST["addToCart"], $ord_GID);
						$i = 0;
						foreach($temp as $val)
						{
							$addToCart[$i] = $val;
							$i++;
						}
					}
					else
					{
						$addToCart = $_POST["addToCart"];
					}
						
					
					
					$mcl = array();
					for($i = 0; $i < sizeof($addToCart); $i++)
					{
						$gme_id = $addToCart[$i];
												
						$sql = "select gme_price * $qty as g_price FROM gametbl WHERE gme_id = $gme_id";
						$res = mysqli_query($myCon, $sql);
						
						if($res)
						{
							$record = mysqli_fetch_assoc($res);
							$gme_price = $record["g_price"];
							$mcl[$i] = array($gme_id, $gme_price);
						}
					} 
					
					
					for($i = 0; $i < sizeof($mcl); $i++)
					{
						$gme_id = $mcl[$i][0];
						$gme_price = $mcl[$i][1];
						$sql = "Insert Into ordertbl(ord_cust_id, ord_gme_id, ord_qty, ord_price)
								Values($cid, $gme_id, $qty ,$gme_price)";
						$res = mysqli_query($myCon, $sql);
					} 
					
					mysqli_close($myCon);
				}
				
			} 
			else
			{
			$memo[0] = "Your Current Cart is EMPTY!,BUT below are your current Orders from before";
				if(sizeof($ord_GID) == 0)
					$memo[1] = "<h2>Plese Click Browser Back Button To Entry!<h2>";
				else
					$memo[1] = "";
			}	
			
			
			
			$myCon = mysqli_connect("localhost","root","","gamebuydb");
		$sql = "select g.gme_title, o.ord_gme_id, o.ord_qty, o.ord_price from ordertbl as o, gametbl as g where o.ord_cust_id = $cid and g.gme_id = o.ord_gme_id";
		$res = mysqli_query($myCon, $sql);
	
		if($res)
		{
			$mol = array();
			for($row = 1; $row <= mysqli_num_rows($res); $row++)
			{
				$record = mysqli_fetch_assoc($res);
				
				$gTitle = $record["gme_title"];
				$gID = $record["ord_gme_id"];
				$gqty = $record["ord_qty"];
				$gPrice = $record["ord_price"];
				
				$mol[$row] = array($gTitle, $gID, $gqty, $gPrice);
			}				
		}		
		mysqli_close($myCon);	
			
			
			
		
			
			
			
			
			
			
			
			
			
			
		
		}


?>















<html>
<head>
</head>
<body>
<div align="center">
	<h1>Game Buy</h1>
	<?php
	include "cookie_info.php"; 
	?>
	<?php print "<h1>Order So Far for ".$custData[1]." ".$custData[2]."</h1>"; ?>
	<form method="POST" name="myCart" action="processGameOrders.php">
	<?php print $memo[0]; ?>
	<table border="1" width="600">
		<tr>
			<th width="45%">Title</th>
			<th width="5%">ID</th>
			<th width="15%">Qty</th>
			<th width="35%">Price/Copy</th>
		</tr>
		<?php
			
			for($i = 1; $i <= sizeof($mol); $i++)
			{
				print "<tr align = 'center'>";
				print "<td>".$mol[$i][0]."</td>";
				print "<td>".$mol[$i][1]."</td>";
				print "<td>".$mol[$i][2]."</td>";
				print "<td>".$mol[$i][3]."</td>";
				print "</tr>";
				$total += $mol[$i][3];
				
			}
			print "<tr align = 'right'>";
			print "<td colspan='3'>Total:</td>";
			print "<td align = 'center'>$".$total."</td>";
			print "</tr>"; 
		?>
		
		
	</table>

	<?php
		if($memo[1] == "")
		{
			print "Enter Your Credit Card Number: <input type='text' name='card' id='card'' /><br /><br />";
			print "<input type='submit' name='chkout' value='Check Out' /> Or ";
			print "<input type='submit' name='btnlg' value='Logout' />";
		}
		else
			print $memo[1];
	?>		

		
	
	
	</form>
	
</div>
</body>
</html>