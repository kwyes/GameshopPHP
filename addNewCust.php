<!--#300160096 Chanho Lee addNewCust.php-->


<?php




$errors=array(); 
$errors[0] = "";
$errors[1] = "";
$errors[2] = "";
$errors[3] = "";
	
	
   	function chkinput()
   	{
		global $errors;
		
		if(trim($_POST["fname"]) != "")
		{
			$name = trim($_POST["fname"]);
			if(strlen($name) < 21)
			{
				$errors[0] = "";
			}
			else
			{
				
				$errors[0] = "<font color='red'>*** Your Firstname has Too many characters? ***</font>";
			}
		}
		else
		{
			
			$errors[0] = "<font color='red'>*** Your Firstname? ***</font>";
		}
		
		
		if(trim($_POST["lname"]) != "")
		{
			$name = trim($_POST["lname"]);
			if(strlen($name) < 21)
			{
				$errors[1] = "";
			}
			else
			{
			
				$errors[1] = "<font color='red'>*** Your Lastname has Too many characters? ***</font>";
			}
		}
		else
		{
			
			$errors[1] = "<font color='red'>*** Your Lastname? ***</font>";
		}
			
		
		if(trim($_POST["email"]) != "")
		{
			$name = trim($_POST["email"]);
			if(strlen($name) < 21)
			{
				$errors[2] = "";
			}
			else
			{
				
				$errors[2] = "<font color='red'>*** Your E-mail has Too many characters? ***</font>";
			}
		}
		else
		{
			
			$errors[2] = "<font color='red'>*** Your E-mail? ***</font>";
		}
			
		
		if(trim($_POST["password"]) != "")
		{
			$pass = trim($_POST["password"]);
			if(strlen($pass) == 7)
			{
				if(!is_numeric($pass))
				{
					if(ctype_alpha(substr($pass, 0, 1)) && ctype_alnum(substr($pass, 0, 1)))
						{
							for($i = 0; $i < strlen($pass); $i++)
								{
									$passlt = substr($pass, $i, 1);
									if(!is_numeric($passlt) && ctype_upper($passlt))
										{
											$errors[3] = "<font color='red'>*** Invalid Characters ***</font>";
											break;
										}
								}
						}
				}
				else
				{
					
					$errors[3] = "<font color='red'>*** Your Password Cannot be numeric ***</font>";
				}
				
			}
			else
			{
				
				$errors[3] = "<font color='red'>*** Your Password MUST be 7 characters? ***</font>";
			}
		}
		else
		{
			
			$errors[3] = "<font color='red'>*** Your Password? ***</font>";
		}
	}
	
	
	
	if(isset($_POST["submit"]))
	{
		chkinput();
		
		if($errors[0] == "" && $errors[1] == "" && $errors[2] == "" && $errors[3] == "")
		{
			
			$myCon = mysqli_connect("localhost","root","","gamebuydb");
			if(mysqli_connect_errno())
			{
				printf("connection failed: %s\n",mysqli_connect_error());
			    exit();
			}
			else
			{
				$Lname = trim($_POST["lname"]);
				$Password = trim($_POST["password"]);
				$sql = "Select * From customertbl Where cust_lname = '".$Lname."' And cust_passw = '".$Password."'";
				$res = mysqli_query($myCon, $sql);
				
				if($res)
				{
					if(mysqli_num_rows($res) == 0)
					{
						$FistName = trim($_POST["fname"]);
						$LastName = trim($_POST["lname"]);
						$Email = trim($_POST["email"]);
						$PassWord = trim($_POST["password"]);
						
						$sql = "Insert Into customertbl(cust_fname, cust_lname, cust_email, cust_passw)
								Values('".$FistName."', '".$LastName."', '".$Email."', '".$PassWord."')";
						$res = mysqli_query($myCon, $sql);
						if($res)
						{
							if(mysqli_affected_rows($myCon) == 1)
								header("Location:titleSrch.php");
					    }			
					}
						
					else
					{
						$errors[3] = "<font color='red'>*** Password is Prohibited, Please Re-Enter ***</font>";
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
<title></title>

</head>
<body>
<div align="center">
	
	<h1>Game Buy</h1>
	<h1>New Member</h1>
	
	
	
	<table border="1" cellspacing="1" width="900" >
	<form method="POST" action="<?php print($_SERVER['PHP_SELF']); ?>" >
		
		<tr>
			<td align="right">Enter Your <strong>First Name</strong> (Max 20 Chars.)</td>
			<td><input type="text" name="fname" size="20" value="<?php
				if(isset($_POST['submit']))
					print $_POST['fname'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errors[0]; ?></td>
		</tr>
		<tr>
			<td align="right">Enter Your <strong>Last Name</strong> (Max 20 Chars.)</td>
			<td><input type="text" name="lname" size="20" value="<?php
				if(isset($_POST['submit']))
					print $_POST['lname'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errors[1]; ?></td>
		</tr>
		<tr>
			<td align="right">Your <strong>e-mail<strong> address (Max 20 Chars.)</td>
			<td><input type="text" name="email" size="20" value="<?php
				if(isset($_POST['submit']))
					print $_POST['email'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errors[2]; ?></td>
		</tr>
		<tr>
			<td align="right">
				Your <strong>password</strong>
				<ul>
					<li>MUST BE 7 CHARACTERS</li>
					<li><strong>CANNOT BE</strong> ALL DIGITS</li>
					<li><strong>MUST BEGIN</strong> with a Lowercase LETTER of the alphabet</li>
					<li><strong>ONLY lowercase LETTERS OF <br /> THE ALPHABET ALLOWED</strong></li>
				</ul>
			</td>
			<td><input type="text" name="password" size="7" value="<?php
				if(isset($_POST['submit']))
					print $_POST['password'];
				else
					print "";
			?>" />
			</td>
			<td><?php print $errors[3]; ?></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2"><input type="submit" name="submit" value="Submit"></td>
		</tr>
		
	</table>
	</form>
</div>
</body>
</html>
