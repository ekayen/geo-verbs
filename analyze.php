<html>
 <head>
  <title>Analyze</title>
 </head>
 <body>

 <?php 
	$iv = htmlspecialchars($_GET["inVerb"]);
	exec("C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\xfst -e \"read lexc < C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\geo-verbs-I.txt\" -e \"up $iv\" exit", $output, $rv);
	
/*
	$x = var_dump($output);
	$y = var_dump($rv);
*/
	$w = $output;

	//echo $x." noah ".sizeof($output)." liz ".$rv." bucolic ".$y;
?> 

<p>

<strong>
		<?php
/*			
			for($i = 0; $i < sizeof($w); $i++){
				echo $i.". ".$w[$i]."<br />";
			}
*/			
			if($w[sizeof($w)-1]=="???"){
				echo "No analysis found for ".$iv;
			} else {
				echo "Analysis of ".$iv.": ".$w[sizeof($w)-1];
			}
			
		?>

</strong>
	<hr /> <!-- horizontal rule-->
</p>

 </body>
</html>