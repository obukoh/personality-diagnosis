      <?php
      session_start();
            $q1 = (int)$_POST['q1'];
            $q2 = (int)$_POST['q2'];
            $q3 = (int)$_POST['q3'];
            $q4 = (int)$_POST['q4'];
            $q5 = (int)$_POST['q5'];
            $q6 = (int)$_POST['q6'];
            $q7 = (int)$_POST['q7'];
            $q8 = (int)$_POST['q8'];
            $q9 = (int)$_POST['q9'];
            $q10 = (int)$_POST['q10'];
            // echo $_SESSION['EMAIL'];
            $user_email = $_SESSION['EMAIL'];
            $current_time = date("Y-m-d H:i:s");
            // echo $current_time;

            $pdo = new PDO('mysql:host=localhost;dbname=pd_login;charset=utf8mb4','root','');
            $sql = "INSERT INTO `diagnosis-result`(`email`, `execution_time`, `friendly`, `extrovert`, `emotional`, `positive`, `leader`) VALUES ('$user_email','$current_time',$q2+$q6,$q1+$q7,$q3+$q8,$q5+$q9,$q4+$q10)";
            $qry = $pdo->prepare($sql);
            $qry->execute();
            $pdo = null;

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

            if($q1+$q7>8){
              $ex_in = "内向的というより非常に外交的";
              $ex_in_comment = "あなたは特にこの傾向が強く、常に多くのヒトとの出会いを求めています。
              これはあなたの長所です。これからもどんどん交流の輪を広げていきましょう。";
            }elseif($q1+$q7>5){
              $ex_in = "内向的というより外交的";
              $ex_in_comment = "あなたは新しい友人をつくれる一方で、古くからの友人も大切にしています。
              あなたの周りにはあなたと性格が似ている友人が多いはずです。彼らはあなたが困ったときの支えとなるでしょう。";
            }elseif($q1+$q7>3){
              $ex_in = "外交的というより内向的";
              $ex_in_comment = "あなたは古くからの友人も大切にする一方で、新しく交友の輪を広げることもできます。
              あなたの周りにはあなたと性格が似ている友人が多いはずです。彼らはあなたが困ったときの支えとなるでしょう。";
            }else{
              $ex_in = "外交的というより非常に内向的";
              $ex_in_comment = "あなたは特にこの傾向が強く、ヒトとの友好関係を必要最小限にとどめているようです。
              あなたは彼らとの友好関係を非常に大切に思っており、ヒトとのつながりを深くもつことの大切さに気付いています。";
            }

            if($q3+$q8>8){
              $emo_log = "かなり感受性豊か";
              $emo_log_comment = "あなたは特にこの傾向が強く、ハートで動かされて行動するタイプです。
              情に熱く、困っている人がいたら放っておけないでしょう。思っていることが顔に出やすいので注意が必要です。";
            }elseif($q3+$q8>5){
              $emo_log = "どちらかといえば、感受性豊か";
              $emo_log_comment = "あなたは情に熱い一方で、物事を論理的に考えることができる冷静さも兼ね備えています。
              何か心を揺さぶられたときに、それを解決するための糸口を冷静な頭で考えることができます。
              その器用さは、集団をまとめ上げる大きな原動力となるはずです。";
            }elseif($q3+$q8>3){
              $emo_log = "どちらかといえば、論理的";
              $emo_log_comment = "あなたは物事を論理的に考えることができる冷静さをもつ一方で、熱い心の持ち主でもあります。
              何か心を揺さぶられたときに、それを解決するための糸口を冷静な頭で考えることができます。
              その器用さは、集団をまとめ上げる大きな原動力となるはずです。";
            }else{
              $emo_log = "かなり論理的";
              $emo_log_comment = "あなたは特にこの傾向が強く、まじめでロジカルに物事を考えることができます。
              その性格からどんなに困難な問題があってもきっと解決できるはずです。一方で自分の心に火が付くような興味の対象を一つもてるようにしましょう。";
            }

            if($q5+$q9>8){
              $pos_neg = "かなりポジティブ思考";
              $pos_neg_comment = "あなたはたとえ落ち込むようなことがあっても、すぐに切り替えることができます。
              その前向きな性格は周囲を明るくします。";
            }elseif($q5+$q9>5){
              $pos_neg = "ネガティブ思考というよりは、ポジティブ思考";
              $pos_neg_comment = "あなたは基本的にはポジティブに物事を考えますが、ネガティブな一面ももっています。
              疲れているときや、体調にすぐれないときなど、外部の要因によってネガティブ思考に陥りやすいので注意しましょう。";
            }elseif($q5+$q9>3){
              $pos_neg = "ポジティブ思考というよりは、ネガティブ思考";
              $pos_neg_comment = "あなたは基本的にはネガティブに物事を考えますが、ネガティブな一面ももっています。
              疲れているときや、体調にすぐれないときなど、外部の要因によってネガティブ思考に陥りやすいので注意しましょう。";
            }else{
              $pos_neg = "かなりネガティブ思考";
              $pos_neg_comment = "あなたは物事を後ろ向きに捉えすぎているようです。
              ネガティブに物事を考えてもいいことは一つもありません。常に前向きに明るく物事に取り組むようにしましょう。";
            }

            if($q4+$q10>8){
              $lead = "非常に積極的";
              $lead_comment = "あなたは優れたリーダーシップをもっています。集団で何かに取り組む際に、あなたは問題解決のためによい判断を下すことができます。
              主体的に自信をもって行動することが大切です。";
            }elseif($q4+$q10>5){
              $lead = "どちらかといえば、積極的";
              $lead_comment = "あなたは基本的には積極的に行動しますが、状況によってはその行動が受け身になりがちです。
              それはある意味、空気を読める人ということかもしれません。そのバランスのよさを大切にしましょう。";
            }elseif($q4+$q10>3){
              $lead = "どちらかといえば、消極的";
              $lead_comment = "あなたは基本的に消極的な行動をしますが、状況によっては積極的に行動できるようです。
              普段は「言われたことをやる」という姿勢をもっているあなたですが、自分がリーダーシップを発揮しないといけない状況では、積極的に行動できるようです。";
            }else{
              $lead = "非常に消極的";
              $lead_comment = "あなたはあまりリーダーシップを発揮することが得意ではないようです。
              一方で「言われたこと」にはきちんと取り組む真面目さをもっています。
              そのコツコツ努力する姿勢は必ず評価されるでしょう。";
            }
      ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>あなたの診断結果</title>
  <link rel="stylesheet" href="/css/style.css">

</head>

<body>
  <h1>診断結果</h1>

  <div class="title_pic">
  <img src="https://cdn.pixabay.com/photo/2019/01/17/19/27/data-3938447_960_720.jpg" width="480px" height="318px" alt="分析シートの写真" title="分析シート">
  </div>

  <div class="explanation_result">
    <p>お疲れさまでした<br>
      それではあなたの性格診断の結果をお伝えします<br>
      さっそく見ていきましょう</p>
  </div>

  <h2>興味の対象</h2>
  <p>あなたの興味の対象についての結果をお伝えします。<br>
  あなたは<?php echo $hito_mono?>に興味をもっているようです。<br>
  <?php echo $hito_mono_comment?></p>

  <h2>行動特性</h2>
  <p>あなたの行動特性についての結果をお伝えします。<br>
  あなたは<?php echo $ex_in?>な性格をしています。<br>
  <?php echo $ex_in_comment?></p>

  <h2>思考特性</h2>
  <p>あなたの思考特性についての結果をお伝えします。<br>
  あなたは<?php echo $emo_log?>な性格をしています。<br>
  <?php echo $emo_log_comment?></p>

  <h2>ポジティブ・ネガティブ</h2>
  <p>あなたのポジティブ・ネガティブについての結果をお伝えします。<br>
  あなたは<?php echo $pos_neg?>です。<br>
  <?php echo $pos_neg_comment?></p>

  <h2>リーダーシップ</h2>
  <p>あなたのリーダーシップについての結果をお伝えします。<br>
  あなたは<?php echo $lead?>な性格をしています。<br>
  <?php echo $lead_comment?></p>

<div class="chuo">
  <input type="button" onclick="location.href='./home.php'" value="ホーム画面に戻る">
</div>
  <!-- <input type="button" onclick="history.back()" value="戻る"> -->



</body>


</html>
