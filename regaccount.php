<?php include("head.php"); ?>
		
		<!--action为空操作本页面-->
		<form name="reg" action="regaccount.php" method="post">
			<div id="account">
				<p><span>帐号：</span><input type="text" name="user" size="25" maxlength="20"/></p> 
				<p><span>电子邮箱：</span><input type="text" name="mail" size="25" maxlength="20"/></p>
				<p><span>密码：</span><input type="password" name="pass" size="25" maxlength="20"/></p>    				
				<p><span>重复密码：</span><input type="password" name="repass" size="25" maxlength="20"/></p>
				<p><span>验证码：</span><input type="text" name="validate" size="6" maxlength="4"/>
					<img  title="点击刷新" src="./class/ValidateCode/captcha.php" align="absbottom" onclick="this.src='./class/ValidateCode/captcha.php?'+Math.random();"></img>
				</p>
				<p><input type="submit" name="regaccount" value="注册帐户"/></p>		        
			</div>
		</form>
	</body>
</html>


<?php
//include("base_methods.php");
include("./class/Account.class.php");
//require './class/Account.class.php';

$ac = new Account();
//var_dump($ac);

if($_POST['regaccount']) {
 
	$mail = $_POST[mail];
	$user = $_POST[user];
	$pass = $_POST[pass];
	$repass = $_POST[repass];
	$validate = $_POST[validate];

	$iscnt = 0;

	if(!empty($mail) and !empty($user) and !empty($pass) and !empty($repass)) {

	 	if($ac->verifyMail($mail)) $iscnt++;
		else echo "<font color=red>email格式有误！</font><br><br>";

		if($ac->verifyUserName($user)) $iscnt++;
		else echo "<font color=red>用户名格式有误！</font><br><br>";

		if($pass == $repass) $iscnt++;
		else echo "<font color=red>两次密码输入不一致！</font><br><br>";

		if($validate == $_SESSION["authnum_session"]) $iscnt++;
		else echo "<font color=red>验证码输入有误！</font><br><br>";

		if ($iscnt == 4) 
			if ($ac->reg($user, $pass, $mail))
				echo "<font color=green>帐号注册成功！</font>";
			else
				echo "<font color=red>帐号注册失败！</font>";

	} else echo "<font color=red>参数不能为空,请返回重新填写!</font>";
}

?>

