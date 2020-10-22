<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chatt.php");

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

try {
    $chatt = new Chatt($host, $dbname, $user, $pass);
    $chatt->connectDb();

    if(!isset($_SESSION['User'])) {
      header('location: index.php');
      exit;
    } else {
      if(empty($_POST['title'] && $_POST['categori_id'] && $_POST['curriculum_id'] && $_POST['contents'])) {
        $message = '未入力な項目があります。';
      } else {
        $chatt->chatt_add($_POST,$_SESSION['User']);
        header('location: notice_board.php');
      }

    }


    $db = null;
    $sth = null;

} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP自作</title>
  <link rel="stylesheet" href="../css/bace.css">
  <link rel="stylesheet" href="../css/que.css">
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="notice_board.php">1つ前へ</a>
    </div>
    <div class="header_btn" id="header_blue">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <form action="" method="POST">
        <div class="text">
          <p>質問投稿</p>
        </div>
        <div class="top">
          <div class="text_sub">
            <p>-質問のタイトル-</p>
          </div>
          <input type="text" placeholder="(例)◯◯の◯◯について" id="title" name="title">
        </div>
        <div class="text_sub">
          <p>-カテゴリー選択-</p>
        </div>
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
        </div>
        <div class="text_sub">
          <p>-質問の詳細-</p>
        </div>
        <textarea name="contents"></textarea>
        <p class="error"><?php print(htmlspecialchars($message,ENT_QUOTES)); ?></p>
        <div class="done_btn" id="add_btn">
          <input type="submit" value="投稿開始">
        </div>
      </form>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
