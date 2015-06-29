<!-- 300160096 ChanhoLee cookie_info.php-->
<?php
	if(isset($_COOKIE["customer"]))  
		$custData = unserialize($_COOKIE["customer"]);
	else
		header("Location:gameBuyLogin.php");
?>