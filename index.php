<?php

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
  echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
  echo "<a href='/logout.php'>ログアウトはこちら。</a>";
  exit;
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>あなたの性格診断</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>

    <h1>ログイン</h1>
    <h3>ようこそ、あなたの性格診断へ</h3>

    <hr><br>
    <div align="center">
              <table border="0" cellpadding="6" cellspacing="5">
                  <form action="login.php" method="post">
                      <tr>
                          <th>
                              メールアドレス
                          </th>
                          <td>
                              <input type="text" name="email" value="" size="24">
                          </td>
                      </tr>
                      <tr>
                          <th>
                              パスワード
                          </th>
                          <td>
                              <input type="password" name="password" value="" size="24">
                          </td>
                      </tr>

                      <table border="0" cellpadding="6" cellspacing="5">
                      <tr>
                      <td><input type="submit" value="ログイン"></td>
                      </tr>
                      </table>
                  </form>
              </table>
          </div>


          <hr><br>
          <h3>新規作成はこちら</h3>
          <div align="center">
                    <table border="0" cellpadding="6" cellspacing="5">
                        <form action="signUp.php" method="post">
                            <tr>
                                <th>
                                    メールアドレス
                                </th>
                                <td>
                                    <input type="text" name="email" value="" size="24">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    パスワード
                                </th>
                                <td>
                                    <input type="password" name="password" value="" size="24">
                                </td>
                            </tr>

                            <table border="0" cellpadding="6" cellspacing="5">
                            <tr>
                            <td><input type="submit" value="新規作成"></td>
                            <p>パスワードは半角英数字をそれぞれ１文字以上含んだ８文字以上で設定してください</p>
                            </tr>
                            </table>
                        </form>
                    </table>
                </div>

  </body>
</html>
