<?php

$mysql_host     = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "Portfolio";

$mysql_db = mysql_connect($mysql_host, $mysql_username, $mysql_password);
$mysql    = mysql_select_db($mysql_database);
$json     = "";

if(isset($_GET['stock'])){
	//$mysql_query    = rawurldecode($_GET['mysql']);
	$stock = stripslashes($_GET['stock']);
	//$mysql = mysql_query("SELECT PRICE, DATE_TIME FROM QUOTES WHERE TICKER = \"".$stock."\" AND date_time <= '2012-07-11 16:53:00' AND date_time >= '2012-07-11 05:14:01' ORDER BY DATE_TIME ");
	$mysql = mysql_query("SELECT PRICE, DATE_TIME FROM QUOTES WHERE TICKER = \"".$stock."\" ORDER BY DATE_TIME");
	//SELECT CAST(DATE_TIME AS DATE)DATE_TIME FROM QUOTES WHERE TICKER = "AFLT" limit 1, 5 
	//$mysql          = mysql_query( stripslashes($st = $mysql_query) );
	if($mysql != false and  @mysql_num_rows($mysql) > 0){
		$mysql_num_rows = mysql_num_rows($mysql);		
		
		date_default_timezone_set("Asia/Krasnoyarsk");
		$json .= "[";
		for($i = 0; $i < $mysql_num_rows; $i++){		
			$res_row = mysql_fetch_assoc($mysql);
			$json .= "[";
			//$datetime = date('u', date('U', strtotime($res_row["DATE_TIME"])));
			//$date = strtotime($res_row["DATE_TIME"]);
			$date = date_create($res_row["DATE_TIME"], new DateTimeZone("UTC"))->setTimezone(new DateTimeZone("Asia/Krasnoyarsk"))->format("U");
			//$datetime = $date->format('U');
			$date .= "000";
			$price = $res_row["PRICE"];
			$price = number_format($price, 2, '.', '');

			$json .= "".$date.",".$price;				
			$json .= "]";
			if($i < $mysql_num_rows - 1){
				$json .= ",";
			}#end if
		}#end for
		$json .= "]";
	}
	else{
		$json .= "{";
		$json .= "\"error\": \"".addslashes(mysql_error())."\", ";
		$json .= "\"errno\": \"".addslashes(mysql_errno())."\"  ";
		$json .= "}";
	}
	
	//echo date('Y-m-d H:i:s', 1341954841);
	//echo "<br>", date('U', strtotime('2011-10-06 12:00:00'));
	echo($json);
	/*$mysql_date_str = "2012-07-11 13:06:01";
	$newdate = date('U', strtotime($mysql_date_str));*/	
}

?>