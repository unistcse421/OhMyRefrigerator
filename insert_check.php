<?php

function check_word($name, $IP, $ID, $PWD, $DB){
	
	$link = mysql_connect($IP, $ID, $PWD)
		or die('Could not connect: ' . mysql.error());
	//echo 'Connected Successfully!'. '</br>';
		
mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");

	mysql_select_db($DB) or die ('Could not select database' );
	
	// Performing SQL query
	$query = 'SELECT ingred_name FROM ingred_inform';
	$result = mysql_query($query)or die('Query failed: '. mysql_error());
	
	
	/////////////////////////////////////////////////////////////////////////////////
	// find the similar name matching with input ingredient in DB.cook.ingred_info 
	// $word will be -1 if there exists the same word with $name
	$num = 99999;
	$word = "";
	
	
	while($line = mysql_fetch_assoc($result)){
		foreach ($line as $col_value) {
				
				$lev = levenshtein($name,$col_value);
				
				if( $lev < $num){
					$num = $lev;
					$word = $col_value;
					
				}				
		}
	}
	if($word == $name){
		$word = $name;
	}

	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	//mysql_close($link);
	
	

		return $word;
		
	}
	
	$name = $_REQUEST["name1"];
	
	$word = check_word($name,"localhost","root","asdf1234","db2");
	
	echo $word;
	if($word != $name){
		echo " " . "-1";
	}
	
?>
