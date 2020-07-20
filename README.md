# 性格診断アプリ

## 前書き
こんにちは。業務としてWebAppエンジニアをかじっている者です。今回はXAMPPで性格診断アプリを作ってみました。今まで自分一人でログイン機能付きのアプリを作ったことがなかったのでいい勉強になりました。XAMPPのインストール手順に関しては別記事をご参照ください。ソースコードは[こちら](https://github.com/obukoh/personality-diagnosis)です。

## 構成
XAMPPをインストールすると`C:\xampp\htdocs`がドキュメントルートになります。例えばこの`htdocs`直下に`index.html`や`index.php`などの`index`という名前のファイルを置いた状態で、ブラウザに`http://localhost`と入力するとローカル環境でAppを起動することができます。(事前に`XAMPP Control Panel`内のApacheを`Start`させておいてください)

htdocs下の構成は以下のようになります。

```bash
 C:\xampp\htdocs> ls


    ディレクトリ: C:\xampp\htdocs


Mode                LastWriteTime         Length Name
----                -------------         ------ ----
d-----       2020/07/13     16:41                css
d-----       2020/06/22     10:47                dashboard
d-----       2020/07/13     12:45                img
d-----       2020/06/22     10:47                webalizer
d-----       2020/06/22     10:47                xampp
-a----       2020/07/14     16:19            152 config.php
-a----       2015/07/17      0:32          30894 favicon.ico
-a----       2020/07/15     22:28           5965 home.html
-a----       2020/07/14     16:14           3241 index.php
-a----       2020/07/15     22:29           1524 login.php
-a----       2020/07/14     19:35            909 logout.php
-a----       2020/07/15     22:29           1971 result-list.php
-a----       2020/07/15     22:30          11434 result.php
-a----       2020/07/15     22:03           2174 signUp.php
```

```bash
C:\xampp\htdocs\css> ls


    ディレクトリ: C:\xampp\htdocs\css


Mode                LastWriteTime         Length Name
----                -------------         ------ ----
-a----       2020/07/15     13:44           1394 style.css
```

データベースのテーブル構成については以下のようになります。

```
dbname=pd_login
テーブル: userdata
email 　	varchar(255)	utf8mb4_unicode_ci　unique key
password	varchar(255)	utf8mb4_unicode_ci

テーブル: diagnosis-result
email	varchar(255)	utf8mb4_unicode_ci
execution_time	datetime
friendly	int(11)
extrovert	int(11)
emotional	int(11)
positive	int(11)
leader	    int(11)
```

## ログイン

`htdocs`直下に`index.html`や`index.php`などの`index`という名前のファイルを置いた状態で、ブラウザに`http://localhost`と入力すると`index.php`が表示されます。これがログイン機能の大元になるファイルです。新規登録機能と通常ログイン機能を持たせています。新規登録処理について、メールアドレスとパスワードにはフィルターをかけている。パスワードに関しては正規表現で適切でないものをはじいています。メールアドレスに関しては`filter_var`を利用して、`RFC822`で判定しています。`RFC822`は判定がガバガバ説があるので、ビジネスで使うときは注意です。パスワードはセキュアにデータベースに保存するため`password_hash()`関数を使ってhash化しています。

```php
if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
```

```php
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  return false;
}
```

通常ログイン機能では以下のようにパスワードを処理します。登録時にhash化したパスワードを`password_verify()`で照合しています。

```php
# login.php
if (password_verify($_POST['password'], $row['password'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['EMAIL'] = $row['email'];
  echo 'ログインしました';
  session_write_close();
  header( "Location: ./home.php" ) ;
  exit();

} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}
```

## 性格診断

index.php内のinputタグから`email`と`password`をpostするとそれを`login.php`がデータを受け取り、本人確認が済んだら`home.html`に遷移します。以下が`home.html`の質問文の箇所です。`value`には質問ごとの性格要素の値が入っています。

```html
<form method="post" action="result.php">
    <h2>第一問</h2>
    <p>あなたは外で遊ぶより、家で過ごすほうが好きですか？</p>
    <input type="radio" name="q1" value="1"> かなりそう思う<br>
    <input type="radio" name="q1" value="2"> そう思う<br>
    <input type="radio" name="q1" value="3"> どちらとも言える<br>
    <input type="radio" name="q1" value="4"> あまりそう思わない<br>
    <input type="radio" name="q1" value="5" required> そう思わない<br>
```

## 診断結果

`home.html`で入力した値は`result.php`にpostされます。以下は`value`ごとの性格要素の値を集計して、4分岐でユーザの性格を判定している箇所です。この例だと質問2と質問6はユーザの興味の対象に関する要素を決定する項目です。この2つの質問の`value`を合算してその合計でユーザの性格を4つに分類しています。

```php
# result.php
if($q2+$q6>8){
              $hito_mono = "非常にモノよりヒト";
              $hito_mono_comment = "あなたは特にこの傾向が強く、ヒトと関わっている時間を楽しみに感じています。
              仕事を選ぶ際にもなるべくヒトと関わる仕事を選ぶとよいでしょう。";
            }elseif($q2+$q6>5){
              $hito_mono = "どちらかといえば、モノよりヒト";
              $hito_mono_comment = "あなたはヒトと関わる時間に楽しみを感じる一方で、モノにも興味をもてます。
              何か自分の興味のあるモノやコトに打ち込みながら、それをヒトとシェアできるバランスの良さをもっています。";
            }elseif($q2+$q6>3){
              $hito_mono = "どちらかといえば、ヒトよりモノ";
              $hito_mono_comment = "あなたはモノやコトに打ち込んでいる瞬間に楽しみを感じる一方で、他人にも興味をもてます。
              何か自分の興味のあるモノやコトに打ち込みながら、それをヒトとシェアできるバランスの良さをもっています。";
            }else{
              $hito_mono = "非常にヒトよりモノ";
              $hito_mono_comment = "あなたは特にこの傾向が強く、モノやコトに打ち込んでいる瞬間を楽しみに感じています。
              仕事を選ぶ際にもなるべく一人で集中できる仕事を選ぶとよいでしょう。";
            }
```

## 判定結果の履歴

`home.html`に以下のボタンを設置しています。

```html
<button class="fixed_btn" onclick="location.href='./result-list.php'">過去の診断結果</button>
```

実は`result.php`内でデータベースにそれぞれの結果を保存しています。`home.html`は`result-list.php`に遷移した後、このデータベースに接続します。`result-list.php`では以下のような処理を行っており、ログインしているユーザの`email`カラムを参考に、データベース内の全データを取得して表として出力しています。

```php
# result-list.php
function createHtmlTable($result) {

    $html = "<table border='3' cellspacing='4' cellpadding='4'>";

    $ffields = $result->fetch_fields();
    $html .= "<tr>";
    foreach ($ffields as $val) {
        $html .= "<th>" . $val->name . "</th>";
    }
    $html .= "</tr>";

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
```

## Session

ちなみに、ページ遷移してもログイン時の`email`を利用できるのは`Session`を利用しているからです。`login.php`内では、以下のような処理をしています。

```php
# login.php
$_SESSION['EMAIL'] = $row['email'];
```

遷移した後のページでこの`$_SESSION['EMAIL']`を使うときは、以下のような記述をする必要があります。

```php

  <?php
      session_start();
```


## ハマったこと

### データベースの接続

文字列の変数はちゃんと`'$hoge'`などシングルクオーテーションマーク(あるいはダブルクォーテーションマーク)で囲む必要があります。

```php
# result.php
$pdo = new PDO('mysql:host=localhost;dbname=pd_login;charset=utf8mb4','root','');
            $sql = "INSERT INTO `diagnosis-result`(`email`, `execution_time`, `friendly`, `extrovert`, `emotional`, `positive`, `leader`) VALUES ('$user_email','$current_time',$q2+$q6,$q1+$q7,$q3+$q8,$q5+$q9,$q4+$q10)";
            $qry = $pdo->prepare($sql);
            $qry->execute();
            $pdo = null;
```

### データベースのデータ型

パスワードをhash化していますが、長さには余裕をもたせる必要があります。私は`varchar(16)`とやってしばらくハマっていました。`varchar(255)`にしたら通りました。





