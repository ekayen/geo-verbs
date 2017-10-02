<html>
 <head>
  <title>Analyze</title>
 </head>
 <body>

 <?php 
	$iv = htmlspecialchars($_GET["inVerb"]);
	exec("C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\xfst -e \"read lexc < C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\geo-verbs-I.txt\" -e \"up $iv\" exit", $output, $rv);
	$w = $output;

?> 

<p>

<strong>
		<?php
		
		if($iv==""){
			echo "Please enter a verb";
		} else{		
			$analyzed=0;
			if($w[sizeof($w)-1]=="???"){
				echo "No analysis found for ".$iv;
			} else {
				$analysis = $w[sizeof($w)-1];
				echo "Analysis of ".$iv.": ".$analysis;
				$analyzed=1;
			}
		}
		?>

</strong>

</p><br/>
<p>	
	<?php
		//Check for all possible morphemes:
		$Prev=0;
		$FirstSubj=0;
		$FirstSgObj=0;
		$FirstPlObj=0;
		$SecondObj=0;
		$Vers=0;
		//probably don't need Vers.
		$PFSF=0;
		$PFSFFut=0;
		$ThirdSgSubj=0;
		$ThirdPlSubj=0;
		$Pl=0;
		$Past=0;
		$Aor=0;
		$Opt=0;
		if(preg_match('/Prev\+/', $analysis)){
			$Prev=1;
		}
		if(preg_match('/1Subj\+/', $analysis)){
			$FirstSubj=1;
		}
		if(preg_match('/1SgObj\+/', $analysis)){
			$FirstSgObj=1;
		}
		if(preg_match('/1PlObj\+/', $analysis)){
			$FirstPlObj=1;
		}
		if(preg_match('/2Obj\+/', $analysis)){
			$SecondObj=1;
		}
		if(preg_match('/\+PFSF/', $analysis)){
			$PFSF=1;
		}
		if(preg_match('/\+PFSFFut/', $analysis)){
			$PFSFFut=1;
		}
		if(preg_match('/\+3sg/', $analysis)){
			$ThirdSgSubj=1;
		}
		if(preg_match('/\+3pl/', $analysis)){
			$ThirdPlSubj=1;
		}
		if(preg_match('/\+Pl/', $analysis)){
			$Pl=1;
		}
		if(preg_match('/\+Past/', $analysis)){
			$Past=1;
		}
		if(preg_match('/\+Aor/', $analysis)){
			$Aor=1;
		}
		if(preg_match('/\+Opt/', $analysis)){
			$Opt=1;
		}
	if($analyzed==1 && $iv!=""){
		//Print out screeve info:
		if($PFSFFut==1){
			echo nl2br("Screeve: future indicative\n\r");
		} else if(($Prev==1)&&($Past==1)){
			echo nl2br("Screeve: conditional\n");
		} else if ($Prev==1){
			echo nl2br("Screeve: future indicative\n"); 
		} else if ($Past==1){
			echo nl2br("Screeve: imperfect\n");
		} else {
			echo nl2br("Screeve: present indicative\n");
		}
		//Print out subject info:
		if($FirstSubj==1 && $Pl==1){
			echo nl2br("Subject: first person plural\n");
		} else if($FirstSubj==1){
			echo nl2br("Subject: first person singular\n");
		} else if ($ThirdSgSubj==1){
			echo nl2br("Subject: third person singular\n"); 
		} else if ($ThirdPlSubj==1){
			echo nl2br("Subject: third person plural\n");
		} else if ($Pl==1){
			echo nl2br("Subject: second person plural\n");
		} else {
			echo nl2br("Subject: second person singular\n");
		}
		//Print out object info
		if($FirstPlObj==1){
			echo nl2br("Object: first person plural\n");
		} else if($FirstSgObj==1){
			echo nl2br("Object: first person singular\n");
		} else if ($SecondObj==1 && $Pl==1){
			echo nl2br("Object: second person plural\n"); 
		} else if ($SecondObj==1){
			echo nl2br("Object: second person singular\n");
		} else {
			echo nl2br("Object: none marked\n");
		}
	}
	?>
</p>
	<hr /> <!-- horizontal rule-->
 </body>
</html>
