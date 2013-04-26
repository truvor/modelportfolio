<?php
	if($_GET['id'] == null){
		echo '<tr></tr>';
		exit;
	}
	
	$link = mysql_connect('mysql-env-4992412.jelastic.regruhosting.ru', 'root', 'fF0i9RZixz')
	or die("Could not connect: " . mysql_error());
	mysql_set_charset('utf8',$link); 
	
	mysql_select_db('Portfolio');	
	$query = 'CREATE TABLE IF NOT EXISTS u'.$_GET['id'].' (
					name varchar(12) NOT NULL,
					ticker varchar(12) NOT NULL,
					price float NOT NULL,
					count int(10) NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=cp1251';
	$result = mysql_query($query);
	if (!$result) {
		die('Неверный запрос: ' . mysql_error());
	}	
	
	$sql = 'SELECT * FROM u'.$_GET['id'];
	$result = mysql_query($sql);
	
	if (!$result) {
		echo "Could not successfully run query (".$sql.") from DB: " . mysql_error();
		exit;
	}

	if (mysql_num_rows($result) == 0) {
		exit;
	}
	$i = 51;
	
	echo '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered ruler" id="example1" onselectstart="return false" onmousedown="return false">
						<thead>
						<tr class="header">
							<th>#</th>
							<th>Название</th>
							<th>Тикер</th>
							<th>Цена</th>
							<th>Количество</th>
						</tr>
						</thead>
						<tbody>';
	
	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr id = "item'.$i.'"  ondblclick="selectItem('.$i.')">';
		echo '<td>'.($i-50).'</td><td>'.$row["name"].'</td><td>'.$row["ticker"].'</td><td>'.$row["price"].'</td><td>'.$row["count"].'</td>';
		echo '</tr>';
		$i++;
	}

	echo '</tbody>
		</table>';
	
	mysql_free_result($result);
	mysql_close($link);
?>