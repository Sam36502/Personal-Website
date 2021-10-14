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
    
    <h1>Gift Wishlist</h1>
    <p>
        Every time Christmas or my birthday rolls around, people wrack their
        brains trying to find out what to give me. I always tell them that
        I'd be fine with nothing, but they never accept that answer, so in
        the intention of saving myself and them the trouble, here's a list
        of things I've wanted at some point or another. I'll try to keep it
        updated, but don't take it as gospel; you still have to use your
        noodle when deciding which I'm most likely to appreciate at that
        particular gifting period.
        <br><br>
        Items already bought will be marked in green.
        <br><br>
        When I finally make this into a database
        out of sheer boredom, it should even be sortable, yay!
    </p>

    <table>
        <tr>
            <th>Est. Price</th>
            <th>Item</th>
            <th>Availabe at</th>
            <th>Notes</th>
        </tr>
        <?php
            $csv = array_map('str_getcsv', file("wishlist.csv"));
            array_walk($csv, function(&$a) use ($csv) {
              $a = array_combine($csv[0], $a);
            });
            array_shift($csv); # remove column header

            foreach ($csv as $row) {
                $background = "";
                switch ($row["Status"]) {
                    case "GOT":
                        $background = "#80d184"; break;
                    case "RES":
                        $background = "#F1BB87"; break;
                }
                echo "<tr " . (strcmp($background, "") != 0 ? "style='background-color: " . $background . ";'" : "") . "><td>" . $row["Price"] . "</td><td>" . $row["Item"] . "</td><td><a href='" . $row["URL"] . "'>" . $row["Place"] . "</a></td><td>" . $row["Notes"] . "</td></tr>";
            }
        ?>
    </table>

</body>
</html>