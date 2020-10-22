<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  if(!isset($_SESSION['User'])) {
    header('location: index.php');
    exit;
  } else {
    $rank = $user->rank();
  }

  $db = null;
  $sth = null;
} catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/gt;";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP自作</title>
  <link rel="stylesheet" href="../css/bace.css">
  <link rel="stylesheet" href="../css/rank.css">
  <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p>質問とランキング</p>
      </div>
      <div class="next">
        <div class="next_btn">
          <a href="notice_board.php"  id="next_btn_left">質問掲示板</a>
          <div id="left_arrow1"></div>
          <div id="left_arrow2"></div>
          <div id="left_arrow3"></div>
        </div>
        <div class="next_btn">
          <a href="noticed_board.php" id="next_btn_right">過去の質問集</a>
          <div id="right_arrow1"></div>
          <div id="right_arrow2"></div>
          <div id="right_arrow3"></div>
        </div>
      </div>
      <div class="ranking">
        <div class="text_sub">
          <p>-返答ポイントランキング-</p>
        </div>
        <div class="rank_top">
          <div class="rank_box">
            <p class="rank_number" id="rank_gold">1.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[0]['name'], ENT_QUOTES)); ?>　さん</p>
            <p class="rank_point"><?php print(htmlspecialchars($rank[0]['point'], ENT_QUOTES)); ?>Pt</p>
          </div>
          <div class="rank_box">
            <p class="rank_number" id="rank_silber">2.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[1]['name'], ENT_QUOTES)); ?>　さん</p>
            <p class="rank_point"><?php print(htmlspecialchars($rank[1]['point'], ENT_QUOTES)); ?>Pt</p>
          </div>
          <div class="rank_box">
            <p class="rank_number" id="rank_bronze">3.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[2]['name'], ENT_QUOTES)); ?>　さん</p>
            <p class="rank_point"><?php print(htmlspecialchars($rank[2]['point'], ENT_QUOTES)); ?>Pt</p>
          </div>
        </div>
        <div class="rank_low">
          <div class="rank_box">
            <p class="rank_number">4.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[3]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">5.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[4]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">6.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[5]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">7.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[6]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">8.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[7]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">9.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[8]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
          <div class="rank_box">
            <p class="rank_number">10.</p>
            <p class="rank_name"><?php print(htmlspecialchars($rank[9]['name'], ENT_QUOTES)); ?>　さん</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
