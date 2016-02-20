<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
//在页首先要开启session,
//error_reporting(2047);
session_destroy();
//将session去掉，以每次都能取新的session值;
//用seesion 效果不错，也很方便
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=7" />

		<!--必要样式-->
		<link rel="stylesheet" href="css/pgwmenu.css">

		<style>
			h1 { padding: 30px 0; font: 32px "Microsoft Yahei"; text-align: center;}
			h2 { margin-top: 50px; font: 24px "Microsoft Yahei";}
			body { font-size: 14px; }
			.dowebok-explain { margin-top: 20px; font-size: 14px; text-align: center; color: #f50;}
			.pgwMenu a { padding: 0 30px;}


			form[name='reg'],
			form[name='mod'] {
				margin-top:20px;
				margin-left:20px;
			}

			form[name='quests'] {
				margin-top:20px;
				margin-left:20px;
			}

			#account p, 
			#modifypass p{
				margin-top: 15px;
				line-height: 20px;
				font-size: 14px;
				font-weight: bold;
			}

			#modifypass span, 
			#account span {  
				display: inline-block;
				width: 80px;
			}

			#account img,
			#modifypass img {
				cursor:pointer;
			}

			#account input[type='text'], 
			#account input[type='password'],
			#modifypass input[type='text'], 
			#modifypass input[type='password'] {
				align: center;
				height: 20px;
			}
			
		</style>

<?php
//消除报错
error_reporting(0);

$url = $_SERVER["REQUEST_URI"];

$quest = substr_count($url,"quest.php");
$regaccount = substr_count($url,"regaccount.php");
$modifypass = substr_count($url,"modifypass.php");

$title = "宅你妹魔兽世界";

if($quest >= 1) $title = "任务汉化 - ".$title;
elseif($regaccount >= 1) $title = "新用户注册 - ".$title;
elseif($modifypass >= 1) $title = "帐户密码修改 - ".$title;

?>

		<title><?=$title?></title>
	</head>

	<body>
		<ul class="pgwMenu">
			<li id="active"><a href="index.php">首页</a></li>
			<li><a href="quest.php">任务汉化</a></li>
			<li><a href="regaccount.php">新用户注册</a></li>
			<li><a href="modifypass.php">帐户密码修改</a></li>
		</ul>

		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="js/pgwmenu.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$('.pgwMenu').pgwMenu({
					dropDownLabel: '菜单',
					viewMoreLabel: '更多<span class="icon"></span>'
				});

				$('.pgwMenuCustom').pgwMenu({
					mainClassName: 'pgwMenuCustom',
					dropDownLabel: '菜单',
					viewMoreLabel: '更多<span class="icon"></span>'
				});
			});
		</script>