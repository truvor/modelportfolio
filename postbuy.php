<?php 
	if (empty($_POST[submitButton])){
		header('Location: index.php');
		exit;
	}
	
	$link = mysql_connect('mysql-env-4992412.jelastic.regruhosting.ru', 'root', 'fF0i9RZixz')
	or die("Could not connect: " . mysql_error());
	mysql_select_db('Portfolio');
	mysql_set_charset('utf8',$link); 
	
	if( $_POST[submitButton] == "buy"){
		$query = 'CREATE TABLE IF NOT EXISTS u'.$_POST[uid].' (
  name varchar(12) NOT NULL,
  ticker varchar(12) NOT NULL,
  price float NOT NULL,
  count int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251';
	
		$query = 'SELECT * FROM u'.$_POST[uid].' WHERE ticker = \''.$_POST[ticker].'\'';
		$result = mysql_query($query);
		//$row = mysql_fetch_assoc($result);
		if (mysql_num_rows($result) == 0) {
			$query = 'INSERT INTO u'.$_POST[uid].' (name, ticker, price, count) VALUES ( \''.$_POST[name].'\', \''.$_POST[ticker].'\', \''.$_POST[price].'\', \''.$_POST[count].'\')';
	
			$result = mysql_query($query);
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
		
			header('Location: index.php');
			exit;
		}
		else {
			$query = 'Update u'.$_POST[uid].' SET price =\''.$_POST[price].'\', count = count + '.$_POST[count].' WHERE ticker = \''.$_POST[ticker].'\'';
			$result = mysql_query($query);
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
			header('Location: index.php');
			exit;
		}
		
	
	mysql_close($link);
	header('Location: index.php');
	exit;
	}
	else if( $_POST[submitButton] == "sell"){
		$query1 = 'SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'u'.$_POST[uid].'\'';
		$result = mysql_query($query1);
		if (mysql_num_rows($result) == 0) {
			//table not exists
			header('Location: index.php');
			exit;
		}
		
		$query1 = 'SELECT * FROM u'.$_POST[uid].' WHERE ticker = \''.$_POST[ticker].'\' AND count >= \''.$_POST[count].'\'';	
		$result = mysql_query($query1);	
		$row = mysql_fetch_assoc($result);
		if (mysql_num_rows($result) == 0) {
			//echo "No rows found, nothing to print so am exiting";
			header('Location: index.php');
			exit;
		}
		
		if( $row["count"] == $_POST[count]){
			mysql_query('DELETE FROM u'.$_POST[uid].' WHERE ticker = \''.$_POST[ticker].'\'');
			header('Location: index.php');
			exit;
		}
		else {
			$query = 'Update u'.$_POST[uid].' SET price =\''.$_POST[price].'\', count = count - '.$_POST[count].' WHERE ticker = \''.$_POST[ticker].'\'';
			$result = mysql_query($query);
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
		}
	}
	
	mysql_close($link);
	header('Location: index.php');
	exit;
?>