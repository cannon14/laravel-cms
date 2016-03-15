<?php

/*** Testing instructions ***
 *
 * (Please update this section if you make any changes to the scoring logic)
 *
 * 1) Bad 
 *		Select the first option for all answers EXCEPT
 *		Q9, select the last option (100% or higher) AND
 *		Q10, select the second option (less than 1 year ago)
 * 2) Fair 
 *		Select the first option for all answers EXCEPT
 *		Q10, select the third option (1-3 years ago)
 * 3) Good 
 *		Use first option for all questions
 * 4) Very Good 
 *		Select the first option for all answers EXCEPT
 *		Q1, select the second option (1 credit card) AND
 *		Q1A, select the last option (more than 20 years) AND
 *		Q9, select the second option (0% - 9%)
 * MPG - New Code Block - This code is an addition to the 3rd party code
 */

$answer01 = $_GET['answer-01'];
$answer01FollowUp = $_GET['answer-01-follow-up'];
$answer02 = $_GET['answer-02'];
$answer03 = $_GET['answer-03'];
$answer04 = $_GET['answer-04'];
$answer05 = $_GET['answer-05'];
$answer06 = $_GET['answer-06'];
$answer07 = $_GET['answer-07'];
$answer07FollowUp = $_GET['answer-07-follow-up'];
$answer08 = $_GET['answer-08'];
$answer08FollowUp = $_GET['uestion-08-follow-up'];
$answer09 = $_GET['answer-09'];
$answer10 = $_GET['answer-10'];
// MPG - End New Code Block

$baseScore = 375;
$scoreAccumulator = 0;

// question 1
if ($answer01) {
	if ($answer01 == "A") {
		// do nothing
	}
	elseif ($answer01 == "B") {
		if ($answer01FollowUp == "A" || $answer01FollowUp == "B" || $answer01FollowUp == "C" || $answer01FollowUp == "D" || $answer01FollowUp == "E") {
			$scoreAccumulator = $scoreAccumulator + 5;
		}
		elseif ($answer01FollowUp == "F") {
			$scoreAccumulator = $scoreAccumulator + 15;
		}
		elseif ($answer01FollowUp == "G" || $answer01FollowUp == "H") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
		elseif ($answer01FollowUp == "I") {
			$scoreAccumulator = $scoreAccumulator + 35;
		}
	}
	elseif ($answer01 == "C") {
		if ($answer01FollowUp == "A" || $answer01FollowUp == "B" || $answer01FollowUp == "C" || $answer01FollowUp == "D" || $answer01FollowUp == "E") {
			$scoreAccumulator = $scoreAccumulator + 5;
		}
		elseif ($answer01FollowUp == "F") {
			$scoreAccumulator = $scoreAccumulator + 20;
		}
		elseif ($answer01FollowUp == "G") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
		elseif ($answer01FollowUp == "H") {
			$scoreAccumulator = $scoreAccumulator + 35;
		}
		elseif ($answer01FollowUp == "I") {
			$scoreAccumulator = $scoreAccumulator + 40;
		}
	}
	elseif ($answer01 == "D") {
		if ($answer01FollowUp == "A" || $answer01FollowUp == "B" || $answer01FollowUp == "C" || $answer01FollowUp == "D" || $answer01FollowUp == "E") {
			$scoreAccumulator = $scoreAccumulator + 15;
		}
		elseif ($answer01FollowUp == "F") {
			$scoreAccumulator = $scoreAccumulator + 25;
		}
		elseif ($answer01FollowUp == "G" || $answer01FollowUp == "H") {
			$scoreAccumulator = $scoreAccumulator + 40;
		}
		elseif ($answer01FollowUp == "I") {
			$scoreAccumulator = $scoreAccumulator + 45;
		}
	}
}

// question 2
if ($answer02) {
	if ($answer02 == "A" || $answer02 == "B" || $answer02 == "C" || $answer02 == "D" || $answer02 == "E") {
		// do nothing
	}
	elseif ($answer02 == "F" || $answer02 == "G") {
		$scoreAccumulator = $scoreAccumulator + 10;
	}
	elseif ($answer02 == "H") {
		// test if very long credit history, if so -don't add as much
		if ($answer01FollowUp == "G" || $answer01FollowUp == "H" || $answer01FollowUp == "I") {
			$scoreAccumulator = $scoreAccumulator + 10;
		} else {
			$scoreAccumulator = $scoreAccumulator + 20;
		}
	}
}

// question 3
if ($answer03) {
	if ($answer03 == "A" || $answer03 == "B") {
		$scoreAccumulator = $scoreAccumulator + 15;
	}
	elseif ($answer03 == "C") {
		$scoreAccumulator = $scoreAccumulator + 10;
	}
	elseif ($answer03 == "D" || $answer03 == "E") {
		// do nothing
	}
}

// question 4
if ($answer04) {
	if ($answer04 == "A") {
		// do nothing
	}
	elseif ($answer04 == "B") {
		$scoreAccumulator = $scoreAccumulator + 5;
	}
	elseif ($answer04 == "C") {
		$scoreAccumulator = $scoreAccumulator + 10;
	}
}

// question 5
if ($answer05) {
	if ($answer05 == "A") {
		$scoreAccumulator = $scoreAccumulator + 20;
	}
	elseif ($answer05 == "B") {
		$scoreAccumulator = $scoreAccumulator + 15;
	}
	elseif ($answer05 == "C") {
		$scoreAccumulator = $scoreAccumulator + 10;
	}
	elseif ($answer05 == "D") {
		//do nothing
	}
}

// question 6
if ($answer06) {
	if ($answer06 == "A") {
		//do nothing
	}
	elseif ($answer06 == "B" || $answer06 == "C") {
		$scoreAccumulator = $scoreAccumulator + 20;
	}
	elseif ($answer06 == "D" || $answer06 == "E" || $answer06 == "F") {
		$scoreAccumulator = $scoreAccumulator + 5;
	}
	elseif ($answer06 == "G") {
		//do nothing
	}
}

// question 7
if ($answer07) {
	if ($answer07 == "A") {
		if ($answer01FollowUp == "A" || $answer01FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 80;
		}
		elseif ($answer01FollowUp == "C" || $answer01FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 90;
		} else {
			$scoreAccumulator = $scoreAccumulator + 105;
		}
	}
	elseif ($answer07 == "B") {
		if ($answer07FollowUp == "A") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
		elseif ($answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 10;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			// do nothing
		}
	}
	elseif ($answer07 == "C") {
		if ($answer07FollowUp == "A") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
		elseif ($answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 15;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 5;
		}
	}
	elseif ($answer07 == "D") {
		if ($answer07FollowUp == "A") {
			$scoreAccumulator = $scoreAccumulator + 45;
		}
		elseif ($answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 20;
		}
	}
	elseif ($answer07 == "E") {
		if ($answer07FollowUp == "A" || $answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 65;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 20;
		}
	}
	elseif ($answer07 == "F") {
		if ($answer07FollowUp == "A" || $answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 75;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
	}
	elseif ($answer07 == "G") {
		if ($answer07FollowUp == "A" || $answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 80;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 30;
		}
	}
	elseif ($answer07 == "H") {
		if ($answer07FollowUp == "A" || $answer07FollowUp == "B") {
			$scoreAccumulator = $scoreAccumulator + 80;
		}
		elseif ($answer07FollowUp == "C" || $answer07FollowUp == "D") {
			$scoreAccumulator = $scoreAccumulator + 40;
		}
	}
}

// question 8
if ($answer08) {
	if ($answer08 == "A") {
		$scoreAccumulator = $scoreAccumulator + 50;
	}
	elseif ($answer08 == "B") {
		// ask if CC balance is 50% or higher
		if ($answer09 == "G" || $answer09 == "H" || $answer09 == "I" || $answer09 == "J") {
			if ($answer08FollowUp == "A") {
				$scoreAccumulator = $scoreAccumulator + 30;
			}
			elseif ($answer08FollowUp == "B" || $answer08FollowUp == "C" || $answer08FollowUp == "D") {
				$scoreAccumulator = $scoreAccumulator + 15;
			}
		} 
		elseif ($answer07 != "A") {
			$scoreAccumulator = $scoreAccumulator + 20;
		} else {
			$scoreAccumulator = $scoreAccumulator + 35;
		}
	}
	elseif ($answer08 == "C") {
		// ask if CC balance is 50% or higher
		if ($answer09 == "G" || $answer09 == "H" || $answer09 == "I" || $answer09 == "J") {
			if ($answer08FollowUp == "A") {
				$scoreAccumulator = $scoreAccumulator + 20;
			}
			elseif ($answer08FollowUp == "B" || $answer08FollowUp == "C" || $answer08FollowUp == "D") {
				// do nothing
			}
		} elseif ($answer07 != "A") {
			$scoreAccumulator = $scoreAccumulator + 20;
		} else {
			$scoreAccumulator = $scoreAccumulator + 35;
		}
	}
}

// question 9
if ($answer09 == "A") {
	$scoreAccumulator = $scoreAccumulator + 60;
}
elseif ($answer09 == "B") {
	$scoreAccumulator = $scoreAccumulator + 80;
}
elseif ($answer09 == "C") {
	$scoreAccumulator = $scoreAccumulator + 65;
}
elseif ($answer09 == "D") {
	$scoreAccumulator = $scoreAccumulator + 55;
}
elseif ($answer09 == "E") {
	$scoreAccumulator = $scoreAccumulator + 50;
}
elseif ($answer09 == "F") {
	$scoreAccumulator = $scoreAccumulator + 45;
}
elseif ($answer09 == "G") {
	$scoreAccumulator = $scoreAccumulator + 30;
}
elseif ($answer09 == "H") {
	$scoreAccumulator = $scoreAccumulator + 20;
}
elseif ($answer09 == "I") {
	$scoreAccumulator = $scoreAccumulator + 15;
}
elseif ($answer09 == "J") {
	// do nothing
}

// question 10
if ($answer10 == "A") {
	$scoreAccumulator = $scoreAccumulator + 60;
}
elseif ($answer10 == "B") {
	// do nothing
}
elseif ($answer10 == "C") {
	$scoreAccumulator = $scoreAccumulator + 25;
}
elseif ($answer10 == "D") {
	$scoreAccumulator = $scoreAccumulator + 30;
}

$calculatedScore = $baseScore + $scoreAccumulator;
															
$highRange = $calculatedScore + 50;
															
if (!$meanScore) {
	$meanScore = ($calculatedScore + $highRange) / 2;
}

 
/*** MPG - Replacing their scoring categories with our scoring categories ***
 * 
 * if ($meanScore < '600') {
 *	$scorerate = "Very Poor";
 *	$spacerwidth = "25";
 * }
 * elseif ($meanScore >= '600' && $meanScore < '650') {
 *	$scorerate = "Poor";
 *	$spacerwidth = "95";
 * }
 * elseif ($meanScore >= '650' && $meanScore < '700') {
 *	$scorerate = "Fair";
 *	$spacerwidth = "153";
 * }
 * elseif ($meanScore >= '700' && $meanScore < '750') {
 *	$scorerate = "Good";
 *	$spacerwidth = "212";
 * }
 * elseif ($meanScore >= '750' && $meanScore < '800') {
 *	$scorerate = "Very Good";
 * 	$spacerwidth = "277";
 * }
 * elseif ($meanScore >= '800' && $meanScore <= '850') {
 * 	$scorerate = "Excellent";
 * 	$spacerwidth = "350";
 * }
 */

if ($meanScore < 620) {
	$scorerate = 'Poor';
}
elseif ($meanScore >= 620 && $meanScore <= 659) {
	$scorerate = 'Fair';
}
elseif ($meanScore >= 660 && $meanScore <= 749) {
	$scorerate = 'Good';
}
elseif ($meanScore >= 750 && $meanScore <= 850) {
	$scorerate = 'Excellent';
}
$lscorerate = strtolower(str_replace(" ", "", $scorerate));

// MPG - New Code Block -- This code is an addition to the 3rd party code

//print "<h1>$scorerate</h1>\n";
//print "<h2> $calculatedScore (lo) $meanScore (av) $highRange (hi) <h2>\n";

switch ($scorerate) {
	case "Very Poor":
	case "Poor":
		session_start();
		$_SESSION['es_score'] = $meanScore;
		header('refresh: 2; url=bad-credit.php');
	break;

	case "Fair":
		// send to fair-credit.php
		session_start();
		$_SESSION['es_score'] = $meanScore;
		header('refresh: 2; url=fair-credit.php');
	break;
	
	case "Good":
		// send to good-credit.php
		session_start();
		$_SESSION['es_score'] = $meanScore;
		header('refresh: 2; url=good-credit.php');
	break;
	
	// The default case is "excellent" because the bottom rank is unbounded but the top rank is bounded; so if there is no scorerate, it probably means a logic error made the $meanScore go above 850	
	
	case "Very Good":
	case "Excellent":
	default:
		session_start();
		$_SESSION['es_score'] = $meanScore;
		header('refresh: 2; url=excellent-credit.php');
	break;
}

// MPG - End New Code Block

?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Free Credit Score Estimator: Get your free credit score estimated at CreditCards.com';
$metaKeywords = '';
$metaDescription = '';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
?>
	<script src="/javascript/AC_RunActiveContent.js" language="javascript"></script>
	<link rel="stylesheet" type="text/css" href="/css/cc-misc.css">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">
		<div id="loading-container">
			<div id="loading">Please wait while we estimate your credit score...</div>
			<span class="fa fa-spinner fa-spin fa-4x" id="spinner-icon"></span>
		</div>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>

</body>
</html>