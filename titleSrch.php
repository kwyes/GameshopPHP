<!-- 300160096 ChanhoLee titleSrch.php -->

<html>
<head>
<title></title>
</head>
<body>
<div align="center">
	<div>
	<h1>Game Buy</h1>
	<?php
	include 'cookie_info.php';
	print "<h3>Welcome ".$custData[1]." ".$custData[2]."</h3>";
	?>
	</div>
	
		
		
	
	<h2>Title Search</h2>
	<form method="POST" name="Search" action="fetchDisplayGame.php">
	<table border="1">
  <tr>
    <th>Title:</th>
    <th colspan="3"><input type="text" name="txtSrch" id="txtSrch" size="70" /></th>
    <th><input type="submit" name="btnSrch" value="Search" /></th>
  </tr>
  <tr>
    <td rowspan="3"></td>
    <td><strong>Search by:</strong></td>
    <td><select name="SearchBy">
					<option value="begin">Begin With</option>
					<option value="within">Within Title</option>
					<option value="exact">Exact Match</option>
		</select>
	</td>
    <td rowspan="3">
       		<input type="checkbox" name="type[]" id="type[]" value="f" /> First Person Shooter<br />
			<input type="checkbox" name="type[]" id="type[]" value="p" /> Role Play<br />
			<input type="checkbox" name="type[]" id="type[]" value="r" /> Real Time Strategy<br />
			<input type="checkbox" name="type[]" id="type[]" value="s" /> Simulation<br />
			<input type="checkbox" name="type[]" id="type[]" value="t" /> Turn Based<br />
			<strong>All Types (If NO check box is selected)</strong>
	</td>
    <td rowspan="3"></td>
  </tr>
  <tr>
    <td rowspan="2"></td>
    <td><input type="radio" name="orderby" value="orderbytitle" checked /><strong> Order By Title<br /></strong></td>
  </tr>
  <tr>
    <td><input type="radio" name="orderby" value="orderbyprice" /><strong> Order By Price(Highest)<br /></strong></td>
  </tr>
</table>
	<div style="margin-top:15px;"><input type="reset" name="clear" value="Clear" /></div>
	</form>
</div>
</body>
</html>