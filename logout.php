<?php
session_start();

if (isset($_SESSION["EMAIL"])) {
  echo 'Logoutしました。';
  header( "Location: ./index.php" ) ;
} else {
  echo 'SessionがTimeoutしました。';
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
@session_destroy();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>
  <div class="chuo">
    <br><br><input type="button" onclick="location.href='./index.php'" value="トップ画面に戻る">
  </div>

</body>
