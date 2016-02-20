<?php

//include("base_methods.php");
/* get

	1.任务名称
	<div class="h1"><h1>title</h1>	
	'|<h1>(.*)</[^>]+>|U'	[1][1]
	
	2.任务目标
	<div class="text"><!-- item s --><p>objective</p>
	'|<p>(.*)</[^>]+>|U'	[1][0]
	
	3.任务详情
	<h3>任务描述</h3><p>details 1 </p>[<p>details 2 </p>...<p>details n </p>]
	'|<p>(.*)</[^>]+>|U'	[1][1] - [1][n-1]
	
	4.任务交接
	<p>completed</p><h3>任务奖励</h3><div class="rewards">	
	'|<p>(.*)</[^>]+>|U'	[1][n]
 */

function getQuestsSQL($file_name, $min, $max) {

	//连接数据库
	if ( !($mysqli = connMySQL('world')) ) return false;

	//$mysqli->query("set names 'utf8'");
	
	//查询数据库
	if ( $min >=0 and $max >= $min ) $query = $mysqli->query("SELECT id FROM locales_quest where id >= $min and id <= $max");
	else if ($min == -1 and $max == -1) $query = $mysqli->query('SELECT id FROM locales_quest');
	else return false;

	//打开文件
	//$file_name='quests.sql';
	$file_pointer = fopen($file_name,'a');
	//var_dump($query);

	//汉化条数
	$len = 0;
	
	//对待查找的汉字进行转码, 取决于PHP文档自身的编码格式
	$empty = '暂无内容';//iconv('gb2312', 'utf-8','暂无内容');
	$name = '，朋友';	//iconv('gb2312', 'utf-8','，朋友');
	$name2 = ',朋友';	//iconv('gb2312', 'utf-8',',朋友');
	$name3 = ', 朋友';	//iconv('gb2312', 'utf-8',', 朋友');
	
	//循环读行
	//fetch_row()fetch_assoc()
	while($row = $query->fetch_assoc()) {

		//获取网页源码->string
		$url="http://db.178.com/wow/cn/quest/".$row['id'].".html";
		$html = curl_file_get_contents($url);
		//$html = file_get_contents($url); 
		 
		
		//截取目标源码
		$start = strpos($html, '<div class="h1">');
		$html = substr($html, $start, strpos($html, '<div class="rewards">') - $start);
		
		//正则表达式
		//获取任务名称
		preg_match('|<h1>(.*)</[^>]+>|U', $html, $title);
		//获取任务内容
		preg_match_all('|<p>(.*)</[^>]+>|U', $html, $quest);
		
		//任务名称
		if ($title[1] != '' and $title[1] != $empty) 
			$sql = 'UPDATE locales_quest SET Title_loc4="'.str_replace('"', "'", $title[1]); 	//world.
		else continue;	
		
		//获取任务字符串总数
		$cnt = count($quest[1]) - 1;	
		
		//任务目标, 把 " 统一转为 ' 防止SQL执行出错
		if (($quest[1][0]) != '') $sql .= '", Objectives_loc4="'.str_replace('"', "'", $quest[1][0]);
		//任务交接
		if (($quest[1][$cnt]) != '') $sql .= '", CompletedText_loc4="'.str_replace('"', "'", $quest[1][$cnt]);
		
		//任务详情
		$tmpstr = '';
		for ($i = 1; $i < $cnt ; $i++) 
			if ($quest[1][$i] != '') 
				//判断是否是最后条任务详情记录
				if ($i < $cnt - 1)
					$tmpstr .= $quest[1][$i].'$b$b'; 
				else 
					$tmpstr .= $quest[1][$i];
				
			else { $tmpstr = ''; break;} 
			
		if ($tmpstr != '') 
			//字符编码必须统一，否则无法查找替换
			$sql .= '", Details_loc4="'.str_replace('"', "'", str_replace(array($name, $name2, $name3), ', $n', $tmpstr));		
	
	
		//对应的任务号
		$sql .= '" WHERE Id='.$row['id'].";\r\n";	
		
		//写文件
		fwrite($file_pointer, $sql);	
		
		//echo $row[$m]['id'].'.  '.$url.'  Done!<br/>';
		//echo $row[$m]['id'].' / '.$len.' . '.$url.'  Done!<br/>';
		
		$len++;
	}
	
	//关闭文件
	fclose($file_pointer); 

	//释放资源
	$query->free();
	$mysqli->close();

	return $len;
}

//$len = getQuestsSQL('./sql/quests.sql', 7, 7);
//echo "<font color=green>共计汉化/$len/个任务!</font><br>";
//getQuestsSQL('quests.sql', -1, -1); 
//exit();
//print_r($quest);
//print_r($title);
//echo $title.'<br/>';
//var_dump($title);
//echo $html.'<br/>';
//var_dump($html);
//echo $quest[3];
//echo gettype($mysqli).'<br/>';
//$url = $_SERVER["REQUEST_URI"];	
?>