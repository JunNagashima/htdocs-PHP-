<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();


    if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1) {
      header('location: index.php');
      exit;
    } else {
      if(!empty($_POST)) {

        if(empty($_POST['name'] && $_POST['huri'] && $_POST['address'] && $_POST['pass'] && $_POST['plan1'] && $_POST['plan2'] && $_POST['plan3'] && $_POST['plan4']
         && $_POST['plan5'] && $_POST['plan6'] && $_POST['plan7'] && $_POST['plan8'] && $_POST['plan9'] && $_POST['plan10'] && $_POST['plan11']
        )) {
          $message = '未入力な項目があります。';
        } else {
          if (filter_var($_POST['address'], FILTER_VALIDATE_EMAIL)) {
            if(strlen($_POST['pass']) < 8) {
              $message = 'パスワードは８文字以上入力してください';
            } else {
              $user->userAdd($_POST);
              $user->userAd($_POST);
            }
          } else {
            $message = '不正な形式のメールアドレスです。';
          }
        }
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
  <link rel="stylesheet" href="../css/add.css">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
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
        <p>新規登録</p>
      </div>
      <div class="top">
        <div class="text_sub">
          <p>-登録者情報-</p>
        </div>
        <form action="" method="POST" id="add_form">
          <table>
            <tr>
              <td class="add_td_left">名前</td>
              <td class="add_td_right"><input type="text" name="name" class="top_text" id="top_red"></td>
            </tr>
            <tr>
              <td class="add_td_left">フリガナ</td>
              <td class="add_td_right"><input type="text" name="huri" class="top_text" id="top_blue"></td>
            </tr>
            <tr>
              <td class="add_td_left">メールアドレス</td>
              <td class="add_td_right"><input type="text" name="address" class="top_pass" id="top_yellow"></td>
            </tr>
            <tr>
              <td class="add_td_left">パスワード</td>
              <td class="add_td_right"><input type="password" name="pass" class="top_pass"  id="top_red"></td>
            </tr>
          </table>

          <div class="text_sub">
            <p>-カリキュラムの計画-</p>
          </div>
          <div class="plan">
            <div class="plan_box">
              <div class="cari_name">
                <p>ネイル</p>
              </div>
              <input type="date" name="plan1" id="top_blue">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>宮島組</p>
              </div>
              <input type="date" name="plan2" id="top_yellow">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>サングー</p>
              </div>
              <input type="date" name="plan3" id="top_red">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>ガーディアン</p>
              </div>
              <input type="date" name="plan4" id="top_blue">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>PHP・アルゴリズム</p>
              </div>
              <input type="date" name="plan5" id="top_yellow">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>ジョブポップ</p>
              </div>
              <input type="date" name="plan6" id="top_red">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>SQL・オブジェクト指向</p>
              </div>
              <input type="date" name="plan7" id="top_blue">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>PHP自作</p>
              </div>
              <input type="date" name="plan8" id="top_yellow">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>CakePHP</p>
              </div>
              <input type="date" name="plan9" id="top_red">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>Laravel</p>
              </div>
              <input type="date" name="plan10" id="top_blue">
            </div>
            <div class="plan_box">
              <div class="cari_name">
                <p>面談・現場準備</p>
              </div>
              <input type="date" name="plan11" id="top_yellow">
            </div>
          </div>
          <p class="error"><?php print(htmlspecialchars($message,ENT_QUOTES)); ?></p>
          <div class="done_btn" id="add_btn">
            <input type="submit" value="登録開始">
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
