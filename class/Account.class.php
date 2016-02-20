<?php

class Account {

	private $mysqli;



	//构造方法初始化
	public function __construct() {
		//连接数据库
		$this->mysqli = new mysqli('localhost','root','trinity','auth');		
	}

	public function __destruct() {
		//释放资源
		$this->mysqli->close();
	}

	//注册用户
	function reg($user, $pass, $mail) {
		
		if ( ($this->mysqli->connect_errno) ) return false;

		//获取最后注册的ID号
		//$sql = 'select id from account order by id desc';
		//$query = $this->mysqli->query($sql);
		//$row = $query->fetch_row();
		//$accoutid = $row[0] + 1;
		//$sql = 'insert into account (id, username, sha_pass_hash, email)';
		//$sql .= " values ('$accoutid', '$user', SHA1(CONCAT(UPPER('$user'), ':', UPPER('$pass'))), '$mail')";
		//$query->free();	//释放资源


		//不填ID号,ID号MYSQL计数器累加，如将帐号删除，计数器不会重置，需将MYSQL服务重启后才会重置
		$sql = 'insert into account (username, sha_pass_hash, email)';
		$sql .= " values ('$user', SHA1(CONCAT(UPPER('$user'), ':', UPPER('$pass'))), '$mail')";
		
		$query = $this->mysqli->query($sql);

		return $query;
	}

	//获取帐号ID
	private function getId($user) {

		if ( ($this->mysqli->connect_errno) ) return false;

		$sql = "select id from account where username = '$user'";
		$query = $this->mysqli->query($sql);
		$row = $query->fetch_assoc();

		//释放资源
		$query->free();

		//如有该用户就返回ID号，否则返回FLASE
		if ($row) return $row['id']; else return $row;
	}


	//验证帐号有效性，成功返回用户ID号，失败返回空
	function verifyLogin($user, $pass) {

		if ( ($this->mysqli->connect_errno) ) return false;

		$sha_pass = sha1(strtoupper($user).':'.strtoupper($pass));

		//username为约束键
		$sql = "select id from account where sha_pass_hash = '$sha_pass' and username = '$user'";

		//判断是用户名还是邮箱	
		//if (verifyMail($user)) $sql.= "email = '$user'"; else $sql.= "username = '$user'";
		$query = $this->mysqli->query($sql);
		$row = $query->fetch_row();

		//var_dump($row);

		//释放资源
		$query->free();

		if ($row) return $row[0]; else return $row;
	}

	///////////////////////////////////////////////////////////////////////////

	//修改用户密码
	function modifyPass($user, $oldpass, $newpass) {

		if ( ($this->mysqli->connect_errno) ) return false;
		
		//验证帐号获取ID, 连接数据库
		if ( !($id = $this->verifyLogin($user, $oldpass)) ) return false;

		$sql = "update account set sha_pass_hash = sha1(concat(upper('$user'), ':', upper('$newpass'))), sessionkey = '', v = '', s = '' where id = '$id'";
		$query = $this->mysqli->query($sql);

		return $query;
	}




	//验证邮件格式
	function verifyMail($mail) {

		if (substr_count($mail, '@') > 1) return false;
		//if (substr_count($mail, '.') > 1) return false;

		$a = strpos($mail,'@');
		$b = strpos($mail,'.');

		if ($a == 0 or $b == 0) return false;
		if ($a > $b ) return false;

		return true;
	}

	//验证用户名格式,首位必须是字母，由字母和数字组成
	function verifyUserName($user) {

		$no1 = substr($user, 0, 1);
		if ( ctype_upper($no1) or ctype_lower($no1) ) return ctype_alnum($user); else return false;
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////


	//角色转服
	function migrateCharacter($accoutid, $character, $currealm, $newrealm) {
	///待完成

	}


}


/*
//帐号合法性需检测name.name
//if (regAccount('md', 'md', 'edp@163.com')) 
//if ($id = verifyLogin('md', 'md')) 
if ((new Account())->modifyPass('md', 'md2', 'md1')) 
//if (verifyUserName('abc123'))
//if (verifyMail('abc123@1.com.cn'))
//if ($id = (new Account())->verifyLogin('md', 'md1'))
	
	echo '<br/>帐号'.$id.'注册成功!<br/>';
	//echo '<br/>帐号修改成功!<br/>';
else 
	echo "<br/>帐号注册失败!<br/>";

exit();
*/



?>