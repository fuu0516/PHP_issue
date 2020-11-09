<?php 
//ファンクション読み込み

require_once("./login/func_login.php");

$data = file_get_contents("./log/login.txt");
$data = explode( "\n", $data);
$cnt = count($data);

//ログインの判定
if(isset($_POST["user_id"])&&isset($_POST["pass_id"])){
	for ($i=0; $i < $cnt; $i++) { 
		$user_datas = explode("/",$data[$i]);
	if(hash("sha256",$_POST["user_id"])==$user_datas[0]&&hash("sha256",$_POST["pass_id"])==$user_datas[1]){
		$msg = "ログイン成功";
		$_SESSION["db_user"]=$_POST["user_id"];
		$_SESSION["db_pass"]=$_POST["pass_id"];
		header("Location:index.php");
		print_r($_SESSION);
	}else{
		$msg = "入力された値が間違っています。";
	}
	}
}else{
	$msg = "ユーザー名とパスワードを入力してください。";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>ログイン</title>
</head>
<body>
<center>
<h1>ログイン</h1>
<p><?php
	if(isset($msg)){
		echo $msg;
	}
	?></p>
<form name="form1" method="POST" action="">
	<table>
		<tr>
			<td>ユーザー名</td>
			<td><input type="text" name="user_id" value=""></td>
		</tr>
		<tr>
			<td>パスワード</td>
			<td><input type="password" name="pass_id" value=""></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="ログイン"></td>
		</tr>
	</table>
	<a href='new_user.php'>新規ユーザー</a>
</form>
<br><br><br>
テスト用ユーザー名 : testuser<br>
テスト用パスワード : testpass
</center>
</body>
</html>