<?php session_start(); ?>
<html>
	<head>
		<title>
			Sql Query
		</title>
		<style>
			@import url("style.css");
		</style>
	</head>
	<body>	
		<div><h1>Enter sql query<?php
			if(!isset($_SESSION['db']))
			{
				$_SESSION['db']="";
			}
			echo "<hr><font size='5' style='color:#5D6D7E'>Current database:";
			if($_SESSION['db']=="")
			{
				echo"not selected</font>";
			}
			else
			{
				echo "'".$_SESSION['db']."'</font>";
			}
		?></h1>
		<textarea form="sqlform" name="textarea" rows="8" cols="80" autofocus required ></textarea><br><br><br>
		<form action="output.php" method="post" id="sqlform">
			<input type="submit" value="Result" class="btn"/>
		</form>
		
		
		</div>
	</body>
</html>