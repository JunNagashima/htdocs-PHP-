<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chatt.php");
try {
    // MySQLへの接続
  $chatt = new Chatt($host, $dbname, $user, $pass);
  $chatt->connectDb();

  $carrs = [
    1=>'ネイル',
    2=>'宮島組',
    3=>'サングー',
    4=>'ガーディアン',
    5=>'PHP・アルゴリズム',
    6=>'ジョブポップ',
    7=>'SQL・オブジェクト指向',
    8=>'PHP自作',
    9=>'CakePHP',
    10=>'Laravel',
    11=>'面談・現場準備'
  ];

  $cates = [
    1=>'HTML',
    2=>'CSS',
    3=>'JavaScript',
    4=>'jQuery',
    5=>'PHP',
    6=>'mySQL',
    7=>'Laravel'
  ];
  if(!isset($_SESSION['User'])) {
    header('location: index.php');
    exit;
  } else {
    $quedFindAll = $chatt->quedFind();
  }

  if($_POST['curriculum_id']) {
    if($_POST['categori_id']) {
      $quedFindAll = $chatt->searchdAll($_POST['curriculum_id'], $_POST['categori_id']);
    } else {
      $quedFindAll = $chatt->searchdCur($_POST['curriculum_id']);
    }
  } else {
    if($_POST['categori_id']) {
      $quedFindAll = $chatt->searchdCat($_POST['categori_id']);
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
  <link rel="stylesheet" href="../css/notice_board.css">
  <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript" src="../JS/home.js"></script>
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="rank.php">1つ前へ</a>
    </div>
    <div class="header_btn" id="header_blue">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p>過去の質問集</p>
      </div>
      <div class="board_top">
        <form action="" method="POST">
          <div class="selecter">
            <select id="select_blue" name="curriculum_id">
              <option value="" hidden>カリキュラム名</option>
              <?php foreach($carrs as $carr_key => $carr_val) { ?>
                <option value="<?php print(htmlspecialchars($carr_key, ENT_QUOTES)); ?>"><?php print(htmlspecialchars($carr_val, ENT_QUOTES)); ?></option>
              <?php } ?>
            </select>
            <select id="select_yellow" name="categori_id">
              <option value="" hidden>カテゴリ</option>
              <?php foreach($cates as $cate_key => $cate_val) { ?>
                <option value="<?php print(htmlspecialchars($cate_key, ENT_QUOTES)); ?>"><?php print(htmlspecialchars($cate_val, ENT_QUOTES)); ?></option>
              <?php } ?>
            </select>
            <input type="submit" value="検索">
          </div>
        </form>
      </div>
      <?php foreach($quedFindAll as $quedFind) { ?>
      <div class="ques button">
        <div class="que_title ">
          <p><?php print(htmlspecialchars($quedFind['title'],ENT_QUOTES)) ?></p>
        </div>
        <div class="que_content down">
          <p><?php print(htmlspecialchars($quedFind['contents'],ENT_QUOTES)) ?></p>
          <div class="que_anser">
            　<form action="que_anser.php" method="POST">
              <input type="hidden" name="que" value="<?php print(htmlspecialchars($quedFind['id'],ENT_QUOTES)); ?>">
              <div class="done_btn" id="que_anser_inner">
                <input type="submit" value="回答へ">
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
