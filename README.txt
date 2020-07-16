性格診断App「あなたの性格診断」
10問の質問に答えることで、回答者の性格診断を行う。

このREADMEと同じ階層にあるファイルをXAMMPを使う場合、htdocs直下に配置することで起動する。
ローカル環境で動作確認する場合は「http://localhost」または「http://localhost/index.php」


#---性格診断のアルゴリズム---#
それぞれの問題は「ヒト・モノへの興味」「内向性・外向性」「感情的・論理的」
「ポジティブ・ネガティブ」「積極的・受動的」のどれかの要素を持つ。
回答者はそれぞれの質問に対して、5段階の程度(点数)で回答する。
回答後は各質問ごとに点数を集計して、同じ要素同士の点数を合計する。
合計した点数ごとに4つの条件分岐を行い、この4つのレベルに応じて結果をフィードバックする。
回答はデータベースに回答時刻とともに保存され、いつでも過去の診断結果を確認できるようにする。


#---ログイン画面設計---#
新規登録処理と登録済みユーザのログイン処理の2つに分かれる。
新規登録はメールアドレスとパスワードによって行う。
メールアドレスはPHPのfilter_var(hoge,FILTER_VALIDATE_EMAIL)メソッドで行う。
e-mail アドレスが RFC 822 に沿った形式であるかどうかを確かめる。
パスワードは正規表現によって半角英数字をそれぞれ１文字以上含んだ８文字以上で設定
するように制限をかけた。
パスワードはデータベースに保存する際にhash関数によって暗号化している。
登録済みユーザのログイン処理はデータベースにあるメールアドレスとパスワードを比較して行う。


#---データベース設計---#
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
leader	        int(11)


#---ファイル---#
index.php
ログイン画面

signUp.php
新規登録後の遷移画面

login.php
ログイン処理後の遷移画面

logout.php
ログアウト処理後の遷移画面

home.html
性格診断の質問画面
ログアウトボタン
過去の診断結果ボタン

result-list.php
過去の診断結果の表の画面

result.php
診断結果の画面

config.php
データベースのdefine

css/style.css
上記phpファイル、およびhtmlファイル共通のスタイルシート