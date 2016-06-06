<?php



// Accepting the input_lists
$q = $_REQUEST["name1"];

//-----------------------------end
echo

$list = explode(",",$q);


#####
$link = mysql_connect('localhost', 'root', 'asdf1234') 
		or die('Could not connect: ' . mysql.error());
	//echo 'Connected Successfully!'. '</br>';
	
//	$charset = mysql_client_encoding($link);

//echo "The current character set is: $charset\n";

	mysql_select_db('db1') or die ('Could not select database' );
	

#####



	$query = "select * from (select food_name, price from (select distinct food_name, price=0 as price from recipe natural join ingred_inform where food_name not in (select food_name from recipe natural join ingred_inform  where ingred_name not in (select ingred_name from {$tb_name}) and ess_condition = 'y')) as B union (select food_name, sum(price) as price from recipe natural join ingred_inform where ess_condition = 'y' and ingred_name not in (select ingred_name from {$tb_name}) group by food_name having sum(price) < all (select price from {$tb_name}))) as C natural join photo_link order by price asc";


  $re = mysql_query($query);
  
  $count = mysql_num_fields($re);
	
  $i = 0;
  while($result=mysql_fetch_array($re))
  {
    $list[$i] = array($result[0],$result[1],$result[2],$result[3]);
    $i++;
  }


	mysql_close($link);
#####
	
$row = count($list);
$col = count($list[0]);
$count = 0;

for($i=0;$i<$row; $i++){
	for($j=0;$j<$col; $j++){
		if($count != $row*$col - 1)
			echo $list[$i][$j] . ",";
		else
			echo $list[$i][$j];
		$count++;
	}
}
	
?>

