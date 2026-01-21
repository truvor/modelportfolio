<?php
// Check if the feed available
$url =
    "https://www.micex.ru/iss/engines/stock/markets/index/securities/MICEXINDEXCF/calculator.xml?date=" .
    date("Y-m-d") .
    "&lang=ru&calculations.columns=ticker,price";
$Headers = @get_headers($url);
if (!strpos($Headers[0], "200")) {
    echo "Error loading quotes from Moscow Exchange server";
    exit(1);
}

($link = mysql_connect("localhost", "root", "")) or
    die("Could not connect: " . mysql_error());

mysql_set_charset("utf8", $link);
$url =
    "http://www.micex.ru/iss/engines/stock/markets/index/securities/MICEXINDEXCF/calculator.xml?date=" .
    date("Y-m-d") .
    "&lang=ru&calculations.columns=ticker,price";
$xml = simplexml_load_file($url); // Convert XML file to object

mysql_select_db("Portfolio");
// Go over XML data
$i = 1;
foreach ($xml->data->rows->row as $item) {
    echo '<tr id = "item' . $i . '" ondblclick="selectItem(' . $i . ')">';
    $date = new DateTime($item[datetime]);

    $result = mysql_query(
        'SELECT name FROM stocks WHERE ticker = \'' .
            $item[ticker] .
            '\' ORDER BY ticker',
    );
    if (!$result) {
        die("Invalid query: " . mysql_error());
    }
    $row = mysql_fetch_assoc($result);
    echo "<td>" .
        $i .
        "</td><td>" .
        $row["name"] .
        "</td><td>" .
        $item[ticker] .
        "</td><td>" .
        $item[price] .
        "</td><td>" .
        $date->format("H:i:s") .
        "</td>"; // Output information about current quotes
    $i++;
    echo "</tr>";
}
mysql_free_result($result);
mysql_close($link);
?>
