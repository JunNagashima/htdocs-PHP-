<?php
require_once("DB.php");

class Chatt extends DB {

  public function chatt_add($que_add,$queUser) {
    $sql = 'INSERT INTO question(title, contents, categori_id, curriculum_id, user_id)
            VALUES(:title, :contents, :categori_id, :curriculum_id, :user_id);';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':title' => $que_add['title'],
      ':contents' => $que_add['contents'],
      ':categori_id' => $que_add['categori_id'],
      ':curriculum_id' => $que_add['curriculum_id'],
      ':user_id' => $queUser['id'],
    );
    $stmt->execute($params);
  }

  public function queFind() {
    $sql = 'SELECT id, title, contents, user_id FROM question WHERE resolution = 0';
    $stmt = $this->connect->query($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  public function quedFind() {
    $sql = 'SELECT id, title, contents, user_id FROM question WHERE resolution = 1';
    $stmt = $this->connect->query($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  public function queAnserFind($que) {
    $sql = 'SELECT * FROM question q, curriculum c WHERE q.curriculum_id = c.id AND q.id = :id ';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $que,
    );
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }


  public function anserAd($userAd, $que) {
    $sql = 'INSERT INTO ansers(question_id, chat, user_id) VALUES(:question_id, :chat, :user_id)';
    $stmt = $this->connect->prepare($sql);
    $params = array(':question_id' => $que,
                    ':chat' => $_POST['text'],
                    ':user_id' => $userAd);
    $stmt->execute($params);
  }

  public function queResFind($que) {
    $sql = 'SELECT * FROM ansers a, users u WHERE a.user_id=u.id AND a.question_id = :id ORDER BY a.id';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $que,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function queDel($del) {
    $sql ='DELETE question,ansers FROM question LEFT JOIN ansers ON question.id=ansers.question_id WHERE question.id=:id;';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $del,
    );
    $stmt->execute($params);
  }

  public function queCom($com) {
    $sql = 'UPDATE question SET resolution = 1 WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $com);
    $stmt->execute($params);
  }

  public function pointAd($que,$user) {
    $sql = 'UPDATE users LEFT JOIN ansers ON users.id = ansers.user_id SET point = point + 1 WHERE ansers.question_id = :id AND users.id != :user';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $que,
                    ':user'=> $user);
    $stmt->execute($params);
  }

  public function searchAll($curId,$catId) {
    $sql = 'SELECT * FROM question WHERE curriculum_id = :curId AND categori_id = :catId AND resolution = 0';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':curId' => $curId,
      ':catId' => $catId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function searchCur($curId) {
    $sql = 'SELECT * FROM question WHERE curriculum_id = :id AND resolution = 0';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $curId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function searchCat($catId) {
    $sql = 'SELECT * FROM question WHERE categori_id = :id AND resolution = 0';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $catId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function searchdAll($curId,$catId) {
    $sql = 'SELECT * FROM question WHERE curriculum_id = :curId AND categori_id = :catId AND resolution = 1';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':curId' => $curId,
      ':catId' => $catId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function searchdCur($curId) {
    $sql = 'SELECT * FROM question WHERE curriculum_id = :id AND resolution = 1';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $curId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function searchdCat($catId) {
    $sql = 'SELECT * FROM question WHERE categori_id = :id AND resolution = 1';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $catId,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

}
?>
