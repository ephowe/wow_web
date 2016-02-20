<?php

//include("config.php");

//mb_internal_encoding('UTF-8');
//mb_regex_encoding('UTF-8'); 

//消除30秒连接限制
ini_set('max_execution_time', '0');

//连接数据库
function connMySQL($db) {
	
	$mysqli = new mysqli('localhost','root','trinity',$db); 

	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    return false;
	}

	return $mysqli;
}


//获取网页内容
function curl_file_get_contents($url) { 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);    
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
	$result = curl_exec($ch);  
	curl_close($ch);   
	return $result;
} 


?>