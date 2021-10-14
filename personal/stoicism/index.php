<?php

    // Read a random quote from https://github.com/ersel/stoic-thoughts
    $fullQuote = shell_exec('./quote.sh');
    $fields = preg_split('/\r\n|\r|\n/', $fullQuote);
    
    $quote = $fields[0];
    $author = $fields[1];
    $book = $fields[2];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/main.css" type="text/css">

    <title>Personal Page</title>
</head>
<body>
    <header><a href="../index.html">&lt;--- Back to main page</a></header>
    
    <h1>Random Stoic Quote</h1>
    <i>
        <?= $quote ?>
    </i>
    <h4><strong> - <?= $author ?></strong></h4>
    <h5><?= $book ?></h5>

</body>
</html>
