<?php include("head.php"); ?>

		<form name="mod" action="" method="post">
			<div id="modifypass">
				<p><span>帐号：</span><input type="text" name="user" size="25" maxlength="20"/></p> 
				<p><span>旧密码：</span><input type="password" name="oldpass" size="25" maxlength="20"/></p>
				<p><span>新密码：</span><input type="password" name="newpass" size="25" maxlength="20"/></p>    				
				<p><span>重复密码：</span><input type="password" name="repass" size="25" maxlength="20"/></p>
				<p><span>验证码：</span><input type="text" name="validate" size="6" maxlength="4"/>
					<img  title="点击刷新" src="./class/ValidateCode/captcha.php" align="absbottom" onclick="this.src='./class/ValidateCode/captcha.php?'+Math.random();"></img>
				</p>
				<p><input type="submit" name="modifypass" value="修改密码"/></p>		        
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

if($_POST['modifypass']) {
 
	$user = $_POST[user];
	$oldpass = $_POST[oldpass];
	$newpass = $_POST[newpass];
	$repass = $_POST[repass];
	$validate = $_POST[validate];

	$iscnt = 0;

	if(!empty($user) and !empty($oldpass) and !empty($newpass) and !empty($repass)) {

		if($ac->verifyUserName($user)) $iscnt++;
		else echo "<font color=red>用户名格式有误！</font><br><br>";

		if($newpass == $repass) $iscnt++;
		else echo "<font color=red>两次密码输入不一致！</font><br><br>";

		if($validate == $_SESSION["authnum_session"]) $iscnt++;
		else echo "<font color=red>验证码输入有误！</font><br><br>";

		if ($iscnt == 3) 
			if ($ac->modifyPass($user, $oldpass, $newpass))
				echo "<font color=green>密码修改成功！</font>";
			else
				echo "<font color=red>密码修改失败，请检查帐号有效性！</font>";

	} else echo "<font color=red>参数不能为空,请返回重新填写!</font>";
}

?>

