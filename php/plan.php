<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1) {
      header('location: index.php');
      exit;
    } else {
      if($_POST['id']) {
        $planId = $_POST['id'];
        $findPlan = $user->findPlan($_POST['id']);
      }

      if($_POST['plan1']) {
        $planUp = $user->planUp($_POST);
      }
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
  <link rel="stylesheet" href="../css/add.css">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="manage.php">1つ前へ</a>
    </div>
    <div class="header_btn" id="header_blue">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p>計画の変更</p>
      </div>
      <div class="top">
        <form action="" method="POST" id="add_form">
          <div class="text_sub">
            <p>-カリキュラムの計画-</p>
          </div>
          <div class="plan">
            <div class="plan_box">
              <div class="cari_name">
                <p>ネイル</p>
              </div>
              <input type="date" name="plan1" id="top_blue" value=<?php print(htmlspecialchars($findPlan[0]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>宮島組</p>
              </div>
              <input type="date" name="plan2" id="top_yellow" value=<?php print(htmlspecialchars($findPlan[1]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>サングー</p>
              </div>
              <input type="date" name="plan3" id="top_red" value=<?php print(htmlspecialchars($findPlan[2]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>ガーディアン</p>
              </div>
              <input type="date" name="plan4" id="top_blue" value=<?php print(htmlspecialchars($findPlan[3]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>PHP・アルゴリズム</p>
              </div>
              <input type="date" name="plan5" id="top_yellow" value=<?php print(htmlspecialchars($findPlan[4]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>ジョブポップ</p>
              </div>
              <input type="date" name="plan6" id="top_red" value=<?php print(htmlspecialchars($findPlan[5]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>SQL・オブジェクト指向</p>
              </div>
              <input type="date" name="plan7" id="top_blue" value=<?php print(htmlspecialchars($findPlan[6]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>PHP自作</p>
              </div>
              <input type="date" name="plan8" id="top_yellow" value=<?php print(htmlspecialchars($findPlan[7]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>CakePHP</p>
              </div>
              <input type="date" name="plan9" id="top_red" value=<?php print(htmlspecialchars($findPlan[8]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>Laravel</p>
              </div>
              <input type="date" name="plan10" id="top_blue" value=<?php print(htmlspecialchars($findPlan[9]['plan'])) ?>>
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>面談・現場準備</p>
              </div>
              <input type="date" name="plan11" id="top_yellow" value=<?php print(htmlspecialchars($findPlan[10]['plan'])) ?>>
            </div>
          </div>

          <div class="done_btn" id="add_btn">
            <input type="submit" value="変更開始">
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
