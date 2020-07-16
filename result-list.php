<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>過去の診断結果</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <h1>過去の診断結果</h1>




<?php
session_start();

// $pdo = new PDO('mysql:host=localhost;dbname=pd_login;charset=utf8mb4','root','');
// $sql = "SELECT * FROM `diagnosis-result` WHERE email='$_SESSION[EMAIL]'";
// $qry = $pdo->prepare($sql);
// $qry->execute();
// while ($rec = $qry->fetch(PDO::FETCH_ASSOC)){
//   print 'practice_time '.$rec['practice_time'];
//   print'<br />';
//   print 'act '.$rec['act'];
//   print'<br />';
// }
// $pdo = null;

/**
 * HTMLテーブルの生成
 * @param mysqli_result $result
 * @return string
 */
function createHtmlTable($result) {

    $html = "<table border='3' cellspacing='4' cellpadding='4'>";

    // カラム名
    $ffields = $result->fetch_fields();
    $html .= "<tr>";
    foreach ($ffields as $val) {
        $html .= "<th>" . $val->name . "</th>";
    }
    $html .= "</tr>";

    // レコード
    foreach ($result as $row) {
        $html .= "<tr>";
        foreach ($ffields as $val) {
            $value = $row[$val->name];
            $html .= "<td>${value}</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";

    return $html;
}

$link = mysqli_connect('localhost', 'root', '', 'pd_login');
if (mysqli_connect_errno()) {
	die("データベースに接続できません:" . mysqli_connect_error() . "
");
} else {
	 echo "";
}
mysqli_query($link,'SET NAMES utf8');
$query = "SELECT * FROM `diagnosis-result` WHERE email='$_SESSION[EMAIL]'";
if ($result = mysqli_query($link, $query)) {

    echo createHtmlTable($result);

    $result->free();
}
mysqli_close($link);
?>


<div class="chuo">
  <br><br><input type="button" onclick="location.href='./home.php'" value="ホーム画面に戻る">
</div>
</body>
