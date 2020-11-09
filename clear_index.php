<?php
//ファンクション読み込み
require_once("./login/func_login.php");
//ログインのチェックファンクション
LogINCheck();
function h($v){
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

//変数の準備
$CLEAR_FILE = './log/clear_'.$_SESSION['db_user'].'.txt';  //chenge username


//タイムゾーン
date_default_timezone_set('Asia/Tokyo');
$date = date('Y年m月d日H時i分'); //日時（年/月/日/ 時:分）
$text = '';$DATA = [];$BOARD = []; $CLEARBOARD = [];

if(!file_exists($CLEAR_FILE)){
    touch($CLEAR_FILE);
}
if(file_exists($CLEAR_FILE)) {
    $CLEARBOARD = json_decode(file_get_contents($CLEAR_FILE));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
    <center>
    <h1></h1>
    <section class= "main">
        <h1>達成</h1>
        <table style= "border-collapse: collapse">
        <?php foreach((array)$CLEARBOARD as $DATA): ?>
          <tr>
            <td>
              <p style="margin: 10px;"><?= $DATA[2] ?></p>
            </td>
            <td>
              <p><?="達成した日："?><?= $DATA[4]; ?></p>
            </td>
          </tr>
        <?php endforeach; ?>
        </table>
    </section>
    <a href="./index.php">メインページ</a>
    <br>
    <p><a href='./login/logout.php'>ログアウト</a></p>
    </center>
</body>
</html>