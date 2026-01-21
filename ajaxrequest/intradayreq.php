<?php

$mysql_host = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "Portfolio";

$mysql_db = mysql_connect($mysql_host, $mysql_username, $mysql_password);
$mysql = mysql_select_db($mysql_database);
$json = "";

if (isset($_GET["stock"])) {
    $stock = stripslashes($_GET["stock"]);
    $mysql = mysql_query(
        "SELECT PRICE, DATE_TIME FROM quotes WHERE TICKER = \"" .
            $stock .
            "\" ORDER BY DATE_TIME",
    );
    if ($mysql != false and @mysql_num_rows($mysql) > 0) {
        $mysql_num_rows = mysql_num_rows($mysql);

        date_default_timezone_set("Asia/Krasnoyarsk");
        $json .= "[";
        for ($i = 0; $i < $mysql_num_rows; $i++) {
            $res_row = mysql_fetch_assoc($mysql);
            $json .= "[";
            $date = date_create($res_row["DATE_TIME"], new DateTimeZone("UTC"))
                ->setTimezone(new DateTimeZone("Asia/Krasnoyarsk"))
                ->format("U");
            $date .= "000";
            $price = $res_row["PRICE"];
            $price = number_format($price, 2, ".", "");

            $json .= "" . $date . "," . $price;
            $json .= "]";
            if ($i < $mysql_num_rows - 1) {
                $json .= ",";
            }
        }
        $json .= "]";
    } else {
        $json .= "{";
        $json .= "\"error\": \"" . addslashes(mysql_error()) . "\", ";
        $json .= "\"errno\": \"" . addslashes(mysql_errno()) . "\"  ";
        $json .= "}";
    }

    echo $json;
}

?>
