<?php 
	//�������� ������� � ���������� �� �����
	$url = 'http://www.micex.ru/iss/engines/stock/markets/index/securities/MICEXINDEXCF/calculator.xml?date='.date("Y-m-d").'&lang=ru&calculations.columns=ticker,price';
	$Headers = @get_headers($url);
	if(	!strpos( $Headers[0], '200') ) {
		echo "������ �������� ��������� � ������� ���������� �����";
		exit(1);
	}
	
	$link = mysql_connect('localhost', 'root', '')
	or die("Could not connect: " . mysql_error());
	
	$url = 'http://www.micex.ru/iss/engines/stock/markets/index/securities/MICEXINDEXCF/calculator.xml?date='.date("Y-m-d").'&lang=ru&calculations.columns=ticker,price';
	$xml = simplexml_load_file($url);   //�������������� XML-���� � ������
		
	mysql_select_db('Portfolio');
	//���� ��� ������ ���� XML �����	
	foreach ($xml->data->rows->row as $item) {
		$date = new DateTime($item[datetime]);
		//$result = mysql_query('call InsertQuote(\''.$date->format('Y-m-d H:i:s').'\', \''.$item[ticker].'\', '.$item[price].' )');
		
		$query = 'INSERT INTO Portfolio.quotes (date_time, ticker, price) VALUES ( \''.$date->format('Y-m-d H:i:s').'\', \''.$item[ticker].'\', \''.$item[price].'\')';
	
		$result = mysql_query($query);
		if (!$result) {
			die('�������� ������: ' . mysql_error());
		}		
	}
	//mysql_free_result($result);
	mysql_close($link);
?>