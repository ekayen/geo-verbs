<html>
 <head>
  <title>Conjugate</title>
 </head>
 <body>



<p>	
	<?php
	/*
		//Possible screeves:
		$Pres=0;
		$Impf=0;
		$PresSubjunc=0;
		$Fut=0;
		$Cond=0;
		$FutSubjunc=0;
		$Aor=0;
		$Opt=0;
		$Perf=0;
		$Pluperf=0;
		$PerfSubjunc=0;
		//Possible sujects:
		$FirstSgSubj=0;
		$SecondSgSubj=0;
		$ThirdSgSubj=0;
		$FirstPlSubj=0;
		$SecondPlSubj=0;
		$ThirdPlSubj=0;
		//Possible objects
		$FirstSgObj=0;
		$SecondSgObj=0;
		$ThirdSgObj=0;
		$FirstPlObj=0;
		$SecondPlObj=0;
		$ThirdPlObj=0;
	*/
	$subj = htmlspecialchars($_GET["subject"]);
	$obj = htmlspecialchars($_GET["object"]);
	$screeve = htmlspecialchars($_GET["screeve"]);
	$iv = htmlspecialchars($_GET["inVerb"]);
	//Format and print out person info and screeve info:
	$subjText="";
	$objText="";
	$screeveText="";
	if($subj=="1sg"){$subjText="first person singular";}
	if($subj=="2sg"){$subjText="second person singular";}
	if($subj=="3sg"){$subjText="third person singular";}
	if($subj=="1pl"){$subjText="first person plural";}
	if($subj=="2pl"){$subjText="second person plural";}
	if($subj=="3pl"){$subjText="third person plural";}
	if($obj=="1sg"){$objText="first person singular";}
	if($obj=="2sg"){$objText="second person singular";}
	if($obj=="3sg"){$objText="third person singular";}
	if($obj=="1pl"){$objText="first person plural";}
	if($obj=="2pl"){$objText="second person plural";}
	if($obj=="3pl"){$objText="third person plural";}
	if($obj==""){$objText="N/A";}
	if($screeve=="present"){$screeveText="present indicative";}
	if($screeve=="future"){$screeveText="future indicative";}
	if($screeve=="presentSubjunctive"){$screeveText="present subjunctive";}
	if($screeve=="futureSubjunctive"){$screeveText="future subjunctive";}
	if($screeve=="imperfect"){$screeveText="imperfect";}
	if($screeve=="conditional"){$screeveText="conditional";}
	if($screeve=="aorist"){$screeveText="aorist";}
	if($screeve=="optative"){$screeveText="optative";}
	if($screeve=="perfect"){$screeveText="present perfect";}
	if($screeve=="pluperfect"){$screeveText="pluperfect";}
	if($screeve=="perfectSubjunctive"){$screeveText="present Subjunctive";}
	echo nl2br("Subject: ".$subjText."\n");
	echo nl2br("Object: ".$objText."\n");
	echo nl2br("Screeve: ".$screeveText."\n");
	//Generate the analysis of the inVerb with flag diacritics visible
	$conjugationClass="";
	exec("C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\xfst -e \"read lexc < C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\geo-verbs-I.txt\" -e \"set show-flags ON\" -e \"up $iv\" exit", $output, $rv);
	$w = $output;
	if($iv==""){
		echo "Please enter a verb";
	} else{		
		$analyzed=0;
		if($w[sizeof($w)-1]=="???"){
			echo $iv." is not a recognized verb form";
		} else {
			$analysisWithFlags = $w[sizeof($w)-1];
			$analyzed=1;
			//echo nl2br($analysisWithFlags."\n");
			//Determine conjugation class by searching through flag diacritics
			if(preg_match('/conj\.III/', $analysisWithFlags)){
				$conjugationClass="III";
			} else if(preg_match('/conj\.II/', $analysisWithFlags)){
				$conjugationClass="II";
			} else if(preg_match('/conj\.IV/', $analysisWithFlags)){
				$conjugationClass="IV";
			} else if(preg_match('/conj\.I/', $analysisWithFlags)){
				$conjugationClass="I";
			}
			//Print conjugation class:
			echo nl2br("Conjugation class: Class ".$conjugationClass."\n");
			//Capture the root
			preg_match('/(?<=@)[^@]+\+Verb/', $analysisWithFlags, $matches);
			$root=(string)$matches[0];			
			//Generate the string of morphemes to give to xfst:
			$morphString="";
			if($conjugationClass!="IV"){
				//Add your preverb (if future series)
				if($conjugationClass!="III" && ($screeve=="future" || $screeve=="futureSubjunctive" || $screeve=="conditional" || $screeve=="aorist" || $screeve=="optative")){
					$morphString=$morphString."Prev+";
				}
				//Add your personal agreement prefix (if needed)
				if($subj=="1sg" || $subj=="1pl"){
					$morphString=$morphString."1Subj+";
				} else if ($obj=="2sg" || $obj=="2pl"){
					$morphString=$morphString."2Obj+";
				} else if ($obj=="1pl"){
					$morphString=$morphString."1PlObj+";
				} else if ($obj=="1sg"){
					$morphString=$morphString."1SgObj+";
				} 
				//Add version vowel unless it's a perfect screeve or a non-future series type III
				if($screeve!="perfect" && $screeve!="pluperfect" && $screeve!="perfectSubjunctive"){
					if($conjugationClass=="III" && ($screeve=="future" || $screeve=="conditional" || $screeve=="futureSubjunctive" || $screeve=="optative" || $screeve=="aorist")){
						$morphString=$morphString."Vers+";
					} else if ($conjugationClass=="I" || $conjugationClass=="II"){
						$morphString=$morphString."Vers+";
					}
				}
				//Add root:
				$morphString=$morphString.$root;
				//Add PFSF (if not aorist or optative)
				if($screeve!="aorist" && $screeve!="optative"){
					$morphString=$morphString."+PFSF";
				}
				//Add tense suffix (if imperfective or conditional):
				if($screeve=="imperfect" || $screeve=="conditional"){
					$morphString=$morphString."+Past";
				} else if ($screeve=="aorist"){
					$morphString=$morphString."+Aor";
				} else if ($screeve=="optative"){
					$morphString=$morphString."+Opt";
				}
				//Add mood suffix:
				if($screeve=="presentSubjunctive" || $screeve=="futureSubjunctive"){
					$morphString=$morphString."+Subj";
				}
				//Add personal agreement suffixes
				if($subj=="3sg"){
					$morphString=$morphString."+3Sg";
				} else if($subj=="3pl"){
					$morphString=$morphString."+3Pl";
				} else if ($subj!="3sg" && $subj!="3pl" && $conjugationClass=="II"){
					if($screeve=="present" || $screeve=="future"){
						$morphString=$morphString."+N3";	
					}					
					if($subj=="1pl" || $subj=="2pl"){
						$morphString=$morphString."+Pl";
					}
				} else if($subj=="1pl" || $subj=="2pl"){
					$morphString=$morphString."+Pl";
				} else if ($obj=="2pl" || $obj=="3pl"){
					$morphString=$morphString."+Pl";
				}
			} else if($conjugationClass=="II"){
				//TODO: add conjII 
			} else if($conjugationClass=="III"){
				//TODO: add conjIII
			} else if($conjugationClass=="IV"){
				echo nl2br("No Type IV verbs have been learned yet\n");
			} 
		}

		//echo nl2br("Conjugation class is ".$conjugationClass."\n");
		//echo nl2br("morphString is: ".$morphString."\n");
		//Check to make sure they didn't give an object for a type II verb:
		if($conjugationClass=="II" && $obj!=""){
			echo "This verb is intransitive. Cannot have an object.";
		} else{
			//Hand the string to xfst:
			exec("C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\xfst -e \"read lexc < C:\\Users\\ekaye\\Documents\\GitHub\\geo-verbs\\geo-verbs-I.txt\" -e \"down $morphString\" exit", $allOut, $rv2);
			/*
			for($i = 0; $i < sizeof($allOut); $i++){
				echo $i.". ".$allOut[$i]."<br />";
			}
			*/
			$conjForm = $allOut[sizeof($allOut)-1];
			echo nl2br("\n\n Conjugated form: ".$conjForm."\n");
		}			
	}
	
	
	?>
</p>
 </body>
</html>