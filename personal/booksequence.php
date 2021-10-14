<?php

    $sequence = "No Input Yet";
    $SEQ_A6_0 = array(7,0,5,2,1,6,3,4);
    $SEQ_A6_1 = array(8,1,6,3,2,7,4,5);

    if (
        isset($_GET['numpg']) &&
        strcmp($_GET['numpg'], "") != 0
    ) {
        $seq = $SEQ_A6_1;
        if (isset($_GET['dfp'])) {
            $seq = $SEQ_A6_0;
        }

        $sequence = "";
        $numpg = intval($_GET['numpg']);
        
        $quirenum = ceil($numpg / 8);
        for ($i=0; $i<$quirenum; $i++) {
            foreach ($seq as $basenum) {
                $n = $basenum + $i * 8;
                $sequence = $sequence . $n . ",";
            }
        }
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
            <li>Set the paper size to A6 (w 10,5; h 14,8; because MS is retarded and doesn't recognise the need for A6 paper in daily life).</li>
            <li>In print settings: set to print 4 pages per sheet with duplex and Portrait layout.</li>
            <li>Enter the number of pages below:</li>
            <li>Copy the result into the "Pages:" field to select the order to print</li>
            <li>Print & Pray.</li>
        </ol>
    </p>

    <h3>Input Values:</h3>
    <form action="booksequence.php" method="get">
        Document has a different first page (0-indexed):
        <input type="checkbox" name="dfp" id="dfp-field"><br>
        Number of Pages:<br>
        <input type="number" name="numpg" id="numpg-field"><br>
        <input type="submit" value="COMPUTE > ">
    </form>

    <h3>Sequence to Copy:</h3>
    <code><?= $sequence ?></code>

</body>
</html>