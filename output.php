<?php



// Accepting the input_lists
$q = $_REQUEST["name1"];

//-----------------------------end
	

$list = explode(",",$q);


#####
$link = mysql_connect('localhost', 'root', 'asdf1234') 
		or die('Could not connect: ' . mysql.error());
	//echo 'Connected Successfully!'. '</br>';
	
mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");
	mysql_select_db('db2') or die ('Could not select database' );



#####


#####

		
		$count = sizeof($list);
		$tb_name = "input".$list[0];

		$query = "drop table {$tb_name}";
		mysql_query($query);

    $query = "create table {$tb_name}(ingred_name varchar(20) not null primary key, price int default 0)";
    mysql_query($query);

    for($i=2; $i<$count; $i++)
    {
			if($list[$i] != "")
			{
      	$query = "insert into {$tb_name} values('{$list[$i]}',0)";
      	mysql_query($query);
			}
    }

    $query = "update {$tb_name} set price = '{$list[1]}'";
    mysql_query($query);
	

#####



#####

	if($count != 2)
	{
		$query = "select * from (select food_name, price from (select distinct food_name, price=0 as price from recipe natural join ingred_inform where food_name not in (select food_name from recipe natural join ingred_inform  where ingred_name not in (select ingred_name from {$tb_name}) and ess_condition = 'y')) as B union (select food_name, sum(price) as price from recipe natural join ingred_inform where ess_condition = 'y' and ingred_name not in (select ingred_name from {$tb_name}) group by food_name having sum(price) <= all (select price from {$tb_name}))) as C natural join photo_link order by price asc";
	
	
	  $re = mysql_query($query);
	  
	  $count = mysql_num_fields($re);
		
	  $q = 0;
	  while($result=mysql_fetch_array($re))
	  {
	    $list[$q] = array($result[0],$result[1],$result[2],$result[3]);
	    $q++;
	  }
	}
	else
	{
		$money = $list[1];
		$query = "select * from (select food_name, price from (select distinct food_name, price=0 as price from recipe natural join ingred_inform where food_name not in (select food_name from recipe natural join ingred_inform  where ingred_name not in (select ingred_name from {$tb_name}) and ess_condition = 'y')) as B union (select food_name, sum(price) as price from recipe natural join ingred_inform where ess_condition = 'y' and ingred_name not in (select ingred_name from {$tb_name}) group by food_name having sum(price) <= {$money})) as C natural join photo_link order by price asc";
	
	
	  $re = mysql_query($query);
	  
	  $count = mysql_num_fields($re);
		
	  $q = 0;
	  while($result=mysql_fetch_array($re))
	  {
	    $list[$q] = array($result[0],$result[1],$result[2],$result[3]);
	    $q++;
	  }
	}



	mysql_close($link);
#####
	
$row = count($list);
$col = count($list[0]);
$count = 0;

if($q != 0 ) {
for($i=0;$i<$q; $i++){
	for($j=0;$j<$col; $j++){
		if($count != $q*$col - 1)
			echo $list[$i][$j] . ",";
		else
			echo $list[$i][$j];
		$count++;
	}
}
}else {
			echo "";
}
	
?>

