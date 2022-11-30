<?php

$sequence = "No Input Yet";
$SEQ_A5_0 = array(3,0,1,2);
$SEQ_A5_1 = array(4,1,2,3);
$SEQ_A6_0 = array(7,0,5,2,1,6,3,4);
$SEQ_A6_1 = array(8,1,6,3,2,7,4,5);
$SEQ_A8_0 = array(7,0,15,8,5,2,13,10,23,16,31,24,21,18,29,26,9,14,1,6,11,12,3,4,25,30,17,22,27,28,19,20);
$SEQ_A8_1 = array(8,1,16,9,6,3,14,11,24,17,32,25,22,19,30,27,10,15,2,7,12,13,4,5,26,31,18,23,28,29,20,21);

if (
	isset($_GET['numpg']) &&
	strcmp($_GET['numpg'], "") != 0
) {
	$seq = $SEQ_A6_1;
	if (isset($_GET['dfp'])) {
		$seq = $SEQ_A6_0;
	}

	if (
		isset($_GET['format']) &&
		strcmp($_GET['format'], "") != 0
	) {
		$fmt = $_GET['format'];
		switch($fmt) {
		case "a5":
			$seq = $SEQ_A5_1;
			if (isset($_GET['dfp'])) $seq = $SEQ_A5_0;
			break;
		case "a6":
			$seq = $SEQ_A6_1;
			if (isset($_GET['dfp'])) $seq = $SEQ_A6_0;
			break;
		case "a8":
			$seq = $SEQ_A8_1;
			if (isset($_GET['dfp'])) $seq = $SEQ_A8_0;
			break;
		}		
	}

	$sequence = "";
	$numpg = intval($_GET['numpg']);

	$quirenum = ceil($numpg / count($seq));
	$currSeq = "";
	for ($i=0; $i<$quirenum; $i++) {
		foreach ($seq as $basenum) {
			$n = $basenum + $i * count($seq);
			$currSeq = $currSeq . $n . ",";
			if (strlen($currSeq) >= 128) {
				$sequence .= substr($currSeq, 0, -1) . "</code><br><code>";
				$currSeq = "";
				$count = 0;
			}
		}
        }
	$sequence .= $currSeq;
        $sequence = substr($sequence, 0, -1);

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/main.css" type="text/css">

    <title>Personal Page</title>
</head>
<body>
    <header><a href="index.html">&lt;--- Back to main page</a></header>
    
    <h1>How to print A6 Books with Word</h1>
    <p>
        <ol>
            <li>Typeset the document (obviously).</li>
            <li>In print settings: set to print 4 (or 16 for A8) pages per sheet with duplex and Portrait layout.</li>
            <li>Enter the number of pages below:</li>
            <li>Copy the result into the "Pages:" field to select the order to print</li>
            <li>Print & Pray.</li>
        </ol>
    </p>

    <h3>Input Values:</h3>
    <form action="booksequence.php" method="get">
        Document has a different first page (0-indexed):
        <input type="checkbox" name="dfp" id="dfp-field"><br>
	Document Format:
	<select name="format">
		<option value="a5">A5</option>
		<option value="a6">A6</option>
		<option value="a8">A8</option>
	</select><br>
        Number of Pages:<br>
        <input type="number" name="numpg" id="numpg-field"><br>
        <input type="submit" value="COMPUTE > ">
    </form>

    <h3>Sequence to Copy:</h3>
    <code><?= $sequence ?></code>

</body>
</html>
