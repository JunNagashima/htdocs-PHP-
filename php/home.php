<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if(isset($_GET['logout'])) {
    $user->logoutTime($_SESSION['User']['id']);
    $_SESSION = array();
    session_destroy();
  }

  $cssState = 'stateColor';
  $cssStateNot = 'stateNotColor';

  if(!isset($_SESSION['User'])) {
    header('location: index.php');
    exit;
  } else {
    $homeUserId = $_SESSION['User']['id'];

    $homeUser = $user->userAll($_SESSION['User']['id']);



    $homeChattFindAll = $user->homeChattFind($homeUserId);


    if($_POST) {
      foreach($homeUser as $value) {
        if($value['state'] == 0) {
          $homeUserState = $value['curriculum_id'];
          $user->homeUserUp($homeUserId,$homeUserState);
          header("location: home.php");
          break;
        }
      }
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
  <link rel="stylesheet" href="../css/home.css">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet">
  <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript" src="../JS/home.js"></script>
</head>
<body>

  <header>
    <?php if($_SESSION['User']['role'] == 1) { ?>
    <div class="header_btn" id="header_red">
      <a href="manage.php">管理ページ</a>
    </div>
    <?php } ?>
    <div class="header_btn" id="header_blue">
      <a href="rank.php">質問へ</a>
    </div>
    <div class="header_btn" id="header_yellow">
      <a href="?logout=1">ログアウト</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p> <?php print(htmlspecialchars($_SESSION['User']['name'],ENT_QUOTES)) ?>　さんの My Page</p>
      </div>
      <div class="text_sub">
        <p>-計画と進捗度-</p>
      </div>
      <div class="meter">
        <div class="meter_line">
          <div class="meter_box <?php if($homeUser[0]['state'] == 1) {if($homeUser[0]['plan'] >= $homeUser[0]['end_date']) {print($cssState);} else {print($cssStateNot);}}; ?>" id="meter_box1">１</div>
          <div class="meter_box <?php if($homeUser[1]['state'] == 1) { if($homeUser[1]['plan'] >= $homeUser[1]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box2">２</div>
          <div class="meter_box <?php if($homeUser[2]['state'] == 1) { if($homeUser[2]['plan'] >= $homeUser[2]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box3">３</div>
          <div class="meter_box <?php if($homeUser[3]['state'] == 1) { if($homeUser[3]['plan'] >= $homeUser[3]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box4">４</div>
          <div class="meter_box <?php if($homeUser[4]['state'] == 1) { if($homeUser[4]['plan'] >= $homeUser[4]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box5">５</div>
          <div class="meter_box <?php if($homeUser[5]['state'] == 1) { if($homeUser[5]['plan'] >= $homeUser[5]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box6">６</div>
          <div class="meter_box <?php if($homeUser[6]['state'] == 1) { if($homeUser[6]['plan'] >= $homeUser[6]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box7">７</div>
          <div class="meter_box <?php if($homeUser[7]['state'] == 1) { if($homeUser[7]['plan'] >= $homeUser[7]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box8">８</div>
          <div class="meter_box <?php if($homeUser[8]['state'] == 1) { if($homeUser[8]['plan'] >= $homeUser[8]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box9">９</div>
          <div class="meter_box <?php if($homeUser[9]['state'] == 1) { if($homeUser[9]['plan'] >= $homeUser[9]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box10">１０</div>
          <div class="meter_box <?php if($homeUser[10]['state'] == 1) { if($homeUser[10]['plan'] >= $homeUser[10]['end_date']) { print($cssState); } else { print($cssStateNot); }}; ?>" id="meter_box11">１１</div>
        </div>
        <div class="meter_bottom">
          <div class="curri_desc"></div>
          <div class="curri_desc curri_desc1">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[0]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[0]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[0]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[0]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[0]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc2">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[1]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[1]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[1]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[1]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[1]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc3">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[2]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[2]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[2]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[2]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[2]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc4">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[3]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[3]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[3]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[3]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[3]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc5">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[4]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[4]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[4]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[4]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[4]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc6">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[5]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[5]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[5]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[5]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[5]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc7">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[6]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[6]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[6]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[6]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[6]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc8">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[7]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[7]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[7]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[7]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[7]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc9">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[8]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[8]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[8]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[8]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[8]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc10">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[9]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[9]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[9]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[9]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[9]['end_date']));} ?></p>
            </div>
          </div>
          <div class="curri_desc curri_desc11">
            <div class="curri_desc_top">
              <p>カリキュラム名：</p>
              <p><?php print(htmlspecialchars($homeUser[10]['name'],ENT_QUOTES)) ?></p>
              <p>カリキュラム番号：</p>
              <p><?php print(htmlspecialchars($homeUser[10]['number'],ENT_QUOTES)) ?></p>
            </div>
            <div class="curri_desc_bottom">
              <p>終了期限:</p>
              <p><?php print date('Y年m月d日', strtotime($homeUser[10]['plan'])) ?></p>
              <p>終了日:</p>
              <p><?php if($homeUser[10]['end_date'] == null) { print('ーーーーーーー'); } else { print date('Y年m月d日', strtotime($homeUser[10]['end_date']));} ?></p>
            </div>
          </div>
          <form action="" method="POST">
            <div class="done_btn">
              <input type="hidden" name="proDone" value="1">
              <input type="submit" value="完了">
            </div>
          </form>
        </div>
      </div>
      <div class="text_sub">
        <p>-   <?php print(htmlspecialchars($_SESSION['User']['name'],ENT_QUOTES)) ?>　　さんの 質問ログ-</p>
      </div>
        <?php foreach($homeChattFindAll as $homeChattFind) { ?>
          <div class="ques button">
            <div class="que_title ">
              <p><?php print(htmlspecialchars($homeChattFind['title'], ENT_QUOTES)); ?></p>
              <?PHP
              $messageCnt = $user->messageCnt($homeChattFind['id']);
              if($messageCnt == null) {

              } else { ?>
                <p class="messageCnt">質問への返信が届いています</p>
              <?php
              }
              ?>
            </div>

            <div class="que_content down">
              <p><?php print(htmlspecialchars($homeChattFind['contents'], ENT_QUOTES)); ?></p>
              <div class="que_anser">
                <form action="que_anser.php" method="POST">
                  <input type="hidden" name="que" value="<?php print(htmlspecialchars($homeChattFind['id'], ENT_QUOTES)); ?>">
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
