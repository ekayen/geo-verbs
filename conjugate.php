<html>
 <head>
  <title>Analyze</title>
 </head>
 <body>

 <?php 
	$iv = htmlspecialchars($_GET["inVerb"]);
	exec("C:\\Users\\ekaye\\Documents\\bin\\xfst -e \"read lexc < C:\\Users\\ekaye\\Documents\\bin\\geo-verbs-I.txt\" -e \"up $iv\" exit", $output, $rv);
	$w = $output;
?> 

<p>

<strong>
		<?php
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