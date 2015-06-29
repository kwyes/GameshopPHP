<!--#300160096 Chanho Lee fetchDisplayGame.php-->
<?php

$orderBy = "";
$searchBy = "";
$Type = "";
switch($_POST["orderby"])
		{
			case 'orderbytitle':
				$orderBy = "Order By gme_title ASC";
				break;
				
			case 'orderbyprice':
				$orderBy = "Order By gme_price DESC";
				break;
				
			
		} 
if(isset($_POST["txtSrch"]) && $_POST["txtSrch"] != "")
		{		
		switch($_POST["SearchBy"])
			{
				case 'begin':
					$searchBy = "gme_title Like '".$_POST["txtSrch"]."%'";
					break;
					
				case 'within':
					$searchBy = "gme_title Like '%".$_POST["txtSrch"]."%'";
					break;
					
				case 'exact':
					$searchBy = "gme_title = '".$_POST["txtSrch"]."'";
					break;
			}	
			
			
		}
	
			
if(isset($_POST["type"]) && sizeof($_POST["type"]) < 5)
		{	
			$Type = "(";
			for($idx = 0; $idx < sizeof($_POST["type"]); $idx++)
			{
				$Type = $Type."gme_type = '".$_POST["type"][$idx]."'";
				if($idx != sizeof($_POST["type"])-1 )
					$Type = $Type." OR ";
			}
			$Type = $Type.")";
		}
	


		
?>



<html>
<head>
<title></title>
</head>
<body>
<div align="center">
		
	<h1>Game Buy</h1>
	<h2>Title Search Result</h2>
	<form method="POST" name="srchResult" action="addOrderGame.php">
	<table border="1" cellpadding="0" cellspacing="1" width="900">
		<tr>
			<th width="40%">Title</th>
			<th width="25%">Type</th>
			<th width="3%">id</th>
			<th width="10%">Price/Copy</th>
			<th width="12%">Qty</th>
			<th width="10%">Add to Cart</th>
			
		</tr>
		<?php
		if(isset($_POST["btnSrch"]))
		{
			$myCon = mysqli_connect("localhost","root","","gamebuydb");
		if(mysqli_connect_errno())
			{
				exit();
			}
			else
			{
				
				$base = "select * from gametbl";
				
				
				if($_POST["txtSrch"] != "")
				{
					$sql = $base." where ".$searchBy;
					if($Type != "")
						$sql = $sql." AND ".$Type;
					
						
				}
				else
				{
					if($Type != "")
						$sql = $base." where ".$Type;
					else
						$sql = $base;	
				} 
				
				
				$res = mysqli_query($myCon, $sql);
				if($res !== FALSE)
   					 {
    					/*if(mysqli_num_rows($res) == 0)
    						print "No matching";
    					else    		
							{*/
								for($row=1;$row <= mysqli_num_rows($res); $row++)
									{
										$record = mysqli_fetch_assoc($res);
											print "<tr align='center'>";
												if($record["gme_type"] == 'f')
												{
													print "<td>";
													print $record["gme_title"];
													print "</td>";
												}
												elseif($record["gme_type"] == 'p')
												{
													print "<td bgcolor = '#F3E2A9'>";
													print $record["gme_title"];
													print "</td>";
												}
												elseif($record["gme_type"] == 'r')
												{
													print "<td bgcolor = '#F7FE2E'>";
													print $record["gme_title"];
													print "</td>";
												}
												elseif($record["gme_type"] == 's')
												{
													print "<td bgcolor = '#DBA901'>";
													print $record["gme_title"];
													print "</td>";
												}
												elseif($record["gme_type"] == 't')
												{
													print "<td bgcolor = '#F6CED8'>";
													print $record["gme_title"];
													print "</td>";
												}
											
											
											print "<td>";
												switch($record["gme_type"])
												{
													case 'f':
													print "First Person Shooter";
													break;
													case 'p':
													print "Role Play";
													break;
													case 'r':
													print "Real Time Strategy";
													break;
													case 's':
													print "Simulation";
													break;
													case 't':
													print "Turn Based";
													break;
												}
											print "</td>";
											print "<td>";
											print $record["gme_id"];
											print "</td>";
											print "<td>";
											print $record["gme_price"];
											print "</td>";
											print "<td>";
											$today = date("Y-m-d");
											if($today < $record["gme_date"])
											{
											print $record["gme_date"];	
											}
											else
											{
													print "<select name='qty'>";
													print "<option value='1'>1</option>";
													print "<option value='2'>2</option>";
													print "<option value='3'>3</option>";
													print "<option value='4'>4</option>";
													print "<option value='5'>5</option>";
													print "</select>";
													
											}
											print "</td>";
											print "<td><input type='checkbox' name='addToCart[]' value='".$record['gme_id']."' /></td>";
											print "</tr>";
									}			
	
							}
						
			}
		
}
		
		
		?>
		
		
	</table>
	
	<div style="margin-top:15px;">
		<input type='submit' name='submit' value='Submit' /> <input type='reset' name='clear' value='Clear' />
	</div>
	</form>
	
</div>
</body>
</html>