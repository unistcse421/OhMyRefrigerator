<?php

$q = $_REQUEST["name1"];
echo $q;

	$s=mysql_connect("localhost","root","asdf1234") or die("fail");
	mysql_select_db("db1",$s);

	//$query = "select * from input";
	$query = "select * from (select food_name, price from (select distinct food_name, price=0 as price from recipe natural join ingred_inform where food_name not in (select food_name from recipe natural join ingred_inform  where ingred_name not in (select ingred_name from input) and ess_condition = 'y')) as B union (select food_name, sum(price) as price from recipe natural join ingred_inform where ess_condition = 'y' and ingred_name not in (select ingred_name from input) group by food_name having sum(price) < all (select price from input))) as C natural join photo_link order by price asc";
	$re = mysql_query($query);

	while($result = mysql_fetch_array($re))
	{
		echo "$result[0]<br>";
	}

	mysql_close($s);
?>
