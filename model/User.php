<?php
session_start();
require_once("DB.php");

class User extends DB {

  //ログイン機能
  public function login($arr) {
    $sql = 'SELECT * FROM users WHERE name = :name AND address = :address AND pass = :pass';
    $stmt = $this->connect->prepare($sql);
    $params = array(':name' => $arr['name'], ':address' => $arr['address'], ':pass' => $arr['pass']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //ログアウトの時間
  public function logoutTime($userId) {
    $sql = 'UPDATE users SET logout_time = now() WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $userId);
    $stmt->execute($params);
  }

  //user登録のメソッド
  public function userAdd($userAdd) {
    $sql = 'INSERT INTO users(name, huri, address, pass) VALUES(:name, :huri, :address, :pass);';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':name' => $userAdd['name'],
      ':huri' => $userAdd['huri'],
      ':address' => $userAdd['address'],
      ':pass' => $userAdd['pass']
    );
    $stmt->execute($params);
  }

  //progress登録メソッド
  public function userAd($userAdd) {
    $addId = $this->connect->lastInsertId();

    $sql = 'INSERT INTO progress(curriculum_id, plan, user_id) VALUES(:curriculum_id, :plan, :user_id)';
    $stmt = $this->connect->prepare($sql);

    for($planNum = 1; $planNum < 12; $planNum++) {
      $params = array(':curriculum_id' => $planNum,
                      ':plan' => $userAdd['plan'.$planNum],
                      ':user_id' => $addId);
      $stmt->execute($params);
    }
  }

  //home
  public function userAll($homeUserId) {
    $sql = 'SELECT * FROM progress p, curriculum c WHERE p.curriculum_id=c.id AND p.user_id=:user_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id' => $homeUserId);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function homeUserUp($homeUserId,$homeUserState) {
    $sql = 'UPDATE progress SET state = :state, end_date = now() WHERE curriculum_id = :curriculum_id AND user_id=:user_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':state' => 1,
                    ':curriculum_id' => $homeUserState,
                    ':user_id' => $homeUserId);
    $stmt->execute($params);
  }

  //rank.php
  public function rank() {
    $sql = 'SELECT name, point FROM users ORDER BY point desc LIMIT 0,10';
    $stmt = $this->connect->query($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  //manage.php カリキュラム生リスト
  public function manage() {
    $sql = 'SELECT id, name, huri, status FROM users ORDER BY huri ASC';
    $stmt = $this->connect->query($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  //manage.php 生徒名検索
  public function search($searchName) {
    $sql = 'SELECT id, name, huri, status FROM users WHERE name = :name';
    $stmt = $this->connect->prepare($sql);
    $params = array(':name' => $searchName);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  //manage.php ステータス find
  public function statusFind($id) {
    $sql = 'SELECT id, name, huri, status FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //manage.php ステータス
  public function status($manageId, $userId) {
    $sql = 'UPDATE users SET status = :status WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    if($manageId == 0) {
      $staNum = 1;
    } else if($manageId == 1) {
      $staNum = 0;
    };
    $params = array(':status' => $staNum,
                    ':id' => $userId);
    $stmt->execute($params);
  }

  //plan.php  SELECT
  public function findPlan($planId) {
    $sql = 'SELECT * FROM progress WHERE user_id = :user_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id' => $planId);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  //plan.php UPDATE
  public function planUp($upPlan) {
    $sql = 'UPDATE progress SET plan = :plan WHERE curriculum_id = :curriculum_id';
    $stmt = $this->connect->prepare($sql);
    for($planNew = 1; $planNew < 12; $planNew++) {
      $params = array(':plan' => $upPlan['plan'.$planNew],
                      ':curriculum_id' => $planNew);
      $stmt->execute($params);
    }
  }

  //home.php　質問週
  public function homeChattFind($id) {
    $sql = 'SELECT * FROM question WHERE user_id = :user_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id' => $id,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  //home.php メッセージ確認
  public function messageCnt($queId) {
    $sql = 'SELECT u.id FROM users u, question q, ansers a WHERE u.id=q.user_id AND q.id = a.question_id AND a.question_id = :question_id AND u.logout_time < a.time';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':question_id' => $queId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

}

?>
