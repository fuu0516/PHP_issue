<?php
//ファンクション読み込み
require_once("./login/func_login.php");
//ログインのチェックファンクション
LogINCheck();
function h($v){
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}



//変数の準備
$FILE = './log/'.$_SESSION['db_user'].'.txt';  //chenge username
$CLEAR_FILE = './log/clear_'.$_SESSION['db_user'].'.txt';  //chenge username
$id = uniqid(); 

//タイムゾーン
date_default_timezone_set('Asia/Tokyo');
$date = date('Y年m月d日H時i分'); //日時（年/月/日/ 時:分）
$text = '';$DATA = [];$BOARD = []; $CLEARBOARD = [];

if(file_exists($FILE)) {
    print_r($BOARD = json_decode(file_get_contents($FILE)));
}
if(!file_exists($CLEAR_FILE)){
    touch($CLEAR_FILE);
}
if(file_exists($CLEAR_FILE)) {
    echo "<br>"."CLEARBOARD = ";
    print_r($CLEARBOARD = json_decode(file_get_contents($CLEAR_FILE)));
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['txt'] && !empty($_POST['day']))){
        $text = $_POST['txt'];
        $day = $_POST['day'];
        $DATA = [$id, $date, $text,$day];
        $BOARD[] = $DATA;
    file_put_contents($FILE, json_encode($BOARD));
}else if(isset($_POST['del'])){
    //削除ボタンが押された場合

    //新しい全体配列を作る
    $NEWBOARD = [];

    //削除ボタンが押されるとき、すでに$BOARDは存在している
    foreach($BOARD as $DATA){
        //$_POST['del']には各々のidが入っている
        //保存しようとしている$DATA[0]が送信されてきたidと等しくないときだけ配列に入れる
        if($DATA[0] !== $_POST['del']){
            $NEWBOARD[] = $DATA;
        }
    }
    //全体配列をファイルに保存する
    file_put_contents($FILE, json_encode($NEWBOARD));
}

if(isset($_POST['clear'])){
    $NEWBOARD = [];
    $NEWCLEARBOAD = [];
    foreach ($BOARD as $DATA) {
        if($DATA[0] == $_POST['clear']){
            // array_push($CLEARBOARD,$DATA);
            array_push($DATA,$date);
            $CLEARBOARD[] = $DATA;
        }
    }
    
    foreach($BOARD as $DATA){
        if($DATA[0] !== $_POST['clear']){
            $NEWBOARD[] = $DATA;
        }
    }
    file_put_contents($CLEAR_FILE, json_encode($CLEARBOARD));
    file_put_contents($FILE, json_encode($NEWBOARD));
}

header("Location:index.php");
exit;
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
        <h1>やることシステム</h1>
        <form style="margin: 30px;" method= "post">
            <input type= "text" name= "txt">を
            <input type="date" name= "day">日にやる。<br><br>
            <input type= "submit" style="width: 150px;" value= "登録">
        </form>    

        <table style= "border-collapse: collapse">
        <?php foreach((array)$BOARD as $DATA): ?>
        <tr style="margin: 10px;">
        <form method= "post">
            <td>
                <?php echo h($DATA[2]); ?>を
            </td>
            <td>
                <?php
                $date_f = new DateTime($DATA[3]);
                echo date_format($date_f,'Y年m月d日');
                ?>までにやる。
            </td>
            <?php
            $date_f = new DateTime($DATA[3]);
            if((date_format($date_f,'Ymd')-date('Ymd'))==0){
                echo "<td>"."今日中にやる。"."</td>";
            }elseif((date_format($date_f,'Ymd')-date('Ymd'))<1){
                echo "<td>"."時間切れです。"."</td>";
            }else{
            echo "<td>"."残りあと";
            echo date_format($date_f,'Ymd')-date('Ymd');
            echo "日"."</td>";
            }
            ?>
        </form>
        <form method= "post">
            <td>
                <input type= "hidden" name= "clear" value= "<?php echo $DATA[0]; ?>">
                <input type= "submit" style="margin:10px;" value= "達成">
            </td>
        </form>

        <form method="post">
            <td>
                <input type= "hidden" name= "del" value= "<?php echo $DATA[0]; ?>">
                <input type= "submit" style="margin:10px;" value= "削除">
            </td>
        </form>

        </tr>
        <?php endforeach; ?>
        </table>
    </section>
    <a href="./clear_index.php">達成一覧</a>
    <br>
    <p><a href='./login/logout.php'>ログアウト</a></p>
    </center>
</body>
</html>