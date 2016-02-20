<?php include("head.php"); ?>

		<form name="quests" action="quest.php" method="post"/>
			<div id="quest">
		         <span>需要汉化的任务ID:</span>
		         <p><input type="input" name="min" size="5" maxlength="5"/> 
		         ---- <input type="input" name="max" size="5" maxlength="5"/></p>
		         <p><input type="submit" name="getSQL" value="生成SQL" /></p>
			</div>
		</form>
	</body>
</html>

<?php
include("base_methods.php");
include("getQuestsSQL.php");

if($_POST['getSQL']){
 
	$min = $_POST[min];
	$max = $_POST[max];

	$iscnt = 0;

	if(!empty($min) and !empty($max)){

		if($min > $max) echo "<font color=red>id号最小值不能大于最大值!</font><br><br>";
		//else $iscnt++;

		if ($iscnt) 
			if ($len = getQuestsSQL('./sql/quests.sql', $min, $max))
				echo "<font color=green>共计汉化'$len'个任务!</font>";
			else 
				echo "<font color=red>汉化失败!</font><br>";
		else echo "<font color=red>该功能暂不可用！！</font>";

	}else echo "<font color=red>参数不能为空!</font>";
}

?>