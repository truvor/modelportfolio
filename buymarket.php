<?php
	$link = mysql_connect('mysql-env-4992412.jelastic.regruhosting.ru', 'root', 'fF0i9RZixz')
	or die("Could not connect: " . mysql_error());
	mysql_set_charset('utf8',$link); 
	
	mysql_select_db('Portfolio');	
	$sql = 'SELECT * FROM buy_market';
	$result = mysql_query('SELECT * FROM buy_market');
	
	if (!$result) {
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

	if (mysql_num_rows($result) == 0) {
		echo "No rows found, nothing to print so am exiting";
		exit;
	}
	$i = 51;
	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr id = "item'.$i.'"  ondblclick="selectItem('.$i.')">';
		echo '<td>'.($i-50).'</td><td>'.$row["name"].'</td><td>'.$row["ticker"].'</td><td>'.$row["price"].'</td><td>'.$row["count"].'</td>';
		echo '</tr>';
		$i++;
	}

	mysql_free_result($result);
	mysql_close($link);
?>