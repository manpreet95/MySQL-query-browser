<?php session_start(); ?>
<html>
	<head>
		<title>
			Query Output
		</title>
		<style>
			@import url("style.css");
		</style>
	</head>
		<body>
			<div>
				<form action="query.php" align="right">
					<input type="submit" value="new query" class="btn"/>
				</form>
				<font size="5">
				<?php
				if($_SESSION['db'])
					echo "Current database: ".$_SESSION['db']."<br><hr>";
				
				$str=$_REQUEST['textarea'];
				echo"queries: $str";
				if(count($que=explode(";","$str"))==1)			//to change database from 1st query and check the correctness of query
					echo"<br>Invalid Enrty!!!<br>Please use ; at proper places";
				$p=explode(" ","$que[0]");
				if(trim($p[0])=="use")
				{
					$_SESSION['db']=$p[1];
				}
				if(!$con=mysqli_connect("localhost","root","",$_SESSION['db'],"3306"))
				{
					session_destroy();
					die("ERROR:".mysqli_connect_error($con));
				}
				for($i=0;$i<count($que)-1;$i++)
				{
					echo"<br><hr><br>";
					echo"query ".($i+1).": $que[$i];<br>";
					$msc=microtime(true);
					$req[$i]=mysqli_query($con,trim($que[$i]));
					$msc=microtime(true)-$msc;
					if(!$req[$i])
					{
						die("ERROR:".mysqli_error($con));
					}
					else
					{
						echo"query ok. (Query took ".round($msc,5)." seconds.)<br>";
					}
					$p=explode(" ","$que[$i]");
					
				//	echo"<br> iteration ".($i+1)."<br>";
					if(trim($p[0])=="use")			//to change database from any query
					{
						$_SESSION['db']=$p[1];
						mysqli_select_db($con,$p[1]);
						echo"<br>database $p[1] selected<br>Current database:$p[1]<br>";
					}else if(trim($p[0])=="drop"&&trim($p[2])==$_SESSION['db'])
					{
						$_SESSION['db']="";
					}
				/*	for($k=0;$k<count($p);$k++)
					{
						echo'$p['.$k."]=".$p[$k]."    ";
					}	*/
					if(trim($p[0])=="show"||trim($p[0])=="describe"||trim($p[0])=="select")		//output
					{
						echo"hihhhiiiiiiiiiiiiiiiiiiiiiiii;";
						$colObj=mysqli_fetch_field_direct($req[$i],0);
						echo"<table border=1 cellspacing='0' cellpadding='14'><tr>";
						for($j=0;$j<mysqli_num_fields($req[$i]);$j++)
							echo"<th><font size='5'>" .$colObj->name. "</font></th>";
						echo"</tr>";
						if(count($data=mysqli_fetch_array($req[$i]))==0)
						{
							echo"Empty set";
						}
						echo"".count($data);
						while($data=mysqli_fetch_array($req[$i]))
						{
							echo"<tr>";
							for($j=0;$j<sizeof($data)/4;$j++)
								echo"<td height='30'><font size='5'>$data[$j]</font></td>";
							echo"</tr>";
						}
						/*
						while($row = mysqli_fetch_row($req[$i])) {
    echo "<tr>";
    foreach($row as $_column) {
        echo "<td>{$_column}</td>";
    }
    echo "</tr>";
}*/
						
						echo"</table>";
					}
					/*	rows affected
					else if($p[0]=="insert"||)
						echo"affected rows:".mysql_affected_rows($con);
					*/
				}
				mysqli_close($con);
				//for($i=0;$i<count($que)-1;$i++)
			
			
				//if(!$data=mysqli_fetch_array($req))
				//for($i=0;$i<count($data)-1;$i++)
				//	echo"$data[$i]";*/
				?>
				<br>
				</font>
			</div>
		</body>
</html>