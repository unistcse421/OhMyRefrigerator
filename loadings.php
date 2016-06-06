<?php

$q = $_REQUEST["Listid"];



$link = mysql_connect('localhost', 'root', 'asdf1234') 
		or die('Could not connect: ' . mysql.error());
	
mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");



mysql_select_db('db2') or die ('Could not select database');

$db = "input".$q;
//$re = mysql_query("show tables like '{$db}'");
$re = mysql_query("select * from {$db}");
$row = mysql_num_rows($re);
$list = array(); 

if($row > 0)
{
	$query = "select ingred_name from {$db}";
	$re = mysql_query($query);

	$i = 0;
	while($result=mysql_fetch_array($re))
	{
					//$list[$i] =  $result[$i];
					array_push($list,$result[0]);
					$i++;
					//echo $i;
	}
}
else
{
	$query = "create table {$db}(ingred_name varchar(20) not null primary key, price int default 0)";
	mysql_query($query);
}


$length = count($list);
//echo $length.",";
for($j=0; $j<$length-1; $j++)
	echo $list[$j].",";

	echo $list[$length-1];
/*
echo "1번짜증,";
echo "가격,";
echo "그림,";
echo "주소,";
echo "2번짜증,";
echo "가격,";
echo "그림,";
echo "주소";
*/

?>
