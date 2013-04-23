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
		$query = 'SELECT * FROM Portfolio.buy_market WHERE ticker = \''.$_POST[ticker].'\'';
		$result = mysql_query($query);
		//$row = mysql_fetch_assoc($result);
		if (mysql_num_rows($result) == 0) {
			$query = 'INSERT INTO Portfolio.buy_market (name, ticker, price, count) VALUES ( \''.$_POST[name].'\', \''.$_POST[ticker].'\', \''.$_POST[price].'\', \''.$_POST[count].'\')';
	
			$result = mysql_query($query);
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
		
			header('Location: index.php');
			exit;
		}
		else {
			$query = 'Update buy_market SET price =\''.$_POST[price].'\', count = count + '.$_POST[count].' WHERE ticker = \''.$_POST[ticker].'\'';
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
		$query1 = 'SELECT * FROM buy_market WHERE ticker = \''.$_POST[ticker].'\' AND count >= \''.$_POST[count].'\'';	
		$result = mysql_query($query1);	
		$row = mysql_fetch_assoc($result);
		if (mysql_num_rows($result) == 0) {
			//echo "No rows found, nothing to print so am exiting";
			header('Location: index.php');
			exit;
		}
		
		if( $row["count"] == $_POST[count]){
			mysql_query('DELETE FROM buy_market WHERE ticker = \''.$_POST[ticker].'\'');
			header('Location: index.php');
			exit;
		}
		else {
			$query = 'Update buy_market SET price =\''.$_POST[price].'\', count = count - '.$_POST[count].' WHERE ticker = \''.$_POST[ticker].'\'';
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