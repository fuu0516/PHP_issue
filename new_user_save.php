<?php
$file = './login.txt';
$user_data = ''; 
$tmp = "";
if(file_exists($file)){
  $tmp = file_get_contents($file);
}

if(!empty(hash("sha256",$_POST["db_user"]))&&!empty(hash("sha256",$_POST["db_pass"])))
{
  $tmp .= hash("sha256",$_POST["db_user"]);
  $tmp .= "/";
  $tmp .= hash("sha256",$_POST["db_pass"]);
  $tmp .= "\n";
  file_put_contents($file,$tmp);
}
header("Location:login.php");
exit;
?>