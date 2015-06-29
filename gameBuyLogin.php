<!-- 300160096 ChanhoLee gameBuyLogin.php-->
<?php



$errorMessages=array(); 
$errorMessage[0] = "";
$errorMessage[1] = "";
$errorMessage[2] = "";

   	function validate_input()
   	{
		global $errorMessage;
		if(trim($_POST["name"]) != "")
			{
			$name = trim($_POST["name"]);
			if(strlen($name) < 21)
				{
				$errorMessage[0] = "";
				}
			else
				{
				
				$errorMessage[0] = "<font color='red'>***Your Lastname has Too many characters?***</font>";
				}
			}
		else
			{
			
			$errorMessage[0] = "<font color='red'>***Your Lastname?***</font>";
			}
			
		
		if(trim($_POST["password"]) != "")
			{
			$password = trim($_POST["password"]);
			if(strlen($password) == 7)
				{
				$errorMessage[1] = "";
				}
			else
				{
				
				$errorMessage[1] = "<font color='red'>***Your Password Must Have 7 characters?***</font>";
				}
			}
		else
			{
			
			$errorMessage[1] = "<font color='red'>***Your Password?***</font>";
			}
}
	
	
	
	if(isset($_POST["submit"]))
		{
		validate_input();
		if($errorMessage[0] == "" && $errorMessage[1] == "")
			{
			$myCon = mysqli_connect("localhost","root","","gamebuydb");
			if(mysqli_connect_errno())
				{
				exit();
				}
			else
				{
				$Lname = trim($_POST["name"]);
				$Password = trim($_POST["password"]);
				$sql = "Select * From customertbl Where cust_lname = '".$Lname."' And cust_passw = '".$Password."'";
				$res = mysqli_query($myCon, $sql);
				
				if($res)
					{
					if(mysqli_num_rows($res) == 0)
				$errorMessage[2] = "<font color='red'>*** Your Password or Lastname DO NOT MATCH, Please Re-Enter ***</font>";
					else
						{
						$errorMessage[2] = "";
						$record = mysqli_fetch_assoc($res);
						$NameCookie = array($record['cust_id'], $record['cust_fname'], $record['cust_lname']);
						setcookie("customer", serialize($NameCookie));
						header("Location:titleSrch.php");
						}
					}
						
				mysqli_close($myCon);
				}
			}
		
}
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Game Buy</title>
</head>
<body>
<div align="center">
<div>
		<h1>Game Buy</h1>
		<h1>Member Login</h1>
</div>
	
	<form method="POST" action="<?php echo($_SERVER['PHP_SELF']); ?>" >
	<table border="0" cellspacing="10" width="700">
		<tr>
			<th>Enter Your LastName(MAX 20 Characters)</th>
			<td><input type="text" name="name" size="20" value="<?php
				if(isset($_POST['submit']))
					print $_POST['name'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errorMessage[0]; ?></td>
		</tr>
		<tr>
			<th>Enter Your Password(7 Characters)</td>
			<td><input type="text" name="password" size="7" value="<?php
				if(isset($_POST['submit']))
					print $_POST['password'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errorMessage[1]; ?></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="Login" />  <input type="reset" value="Clear" /></td>
			<td></td>
		</tr>
	</table>
	</form>
	<!-- Login Error Message -->
	<div>
		<?php print $errorMessage[2]; ?>
	</div>
	
	<div>
		<font color="#1a1ae6"><b> New Members, Please login here         </b></font>
		
		<a href="addNewCust.php"><input type="button" name="btnNewMember" value="New Member" size="20" /></a>
		
	</div>
	
	
</div>
</body>
</html>