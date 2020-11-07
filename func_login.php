<?php 
//変数の定義
//セッションの使用
session_start();
//ログイン判定
function LogINCheck() {
  global $db_user,$db_pass;
  //入力確認
  if(isset($_SESSION["db_user"])===false || isset($_SESSION["db_pass"])===false ){
    $db_user = $_SESSION["db_user"];
    $db_pass = $_SESSION["db_pass"];
    header("Location:./login.php");
  }
  // 変数との生合成
  // if($_SESSION["db_user"]!==$db_user&&$_SESSION["db_pass"]!==$db_pass){
  //   header("Location:login.php");
  // }
}
?>