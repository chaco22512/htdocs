<?php

require_once '../dbconnect.php';

class UserLogic{
  // ユーザー登録する
  // 引数⇒ array $userData
  // return ⇒ bool $result = true/false
  public static function createUser($userData){

    // resultの初期定義
    $result = false;

    // SQL文には、入れるvalue値を直接書かない⇒プレスホルダー⇒Securityのため
    $sql ='INSERT INTO users (name, email, password) VALUE (?,?,?)';

    // ユーザデータを配列に入れる
    $arr =[];
    $arr[] = $userData['username'] ;//name
    $arr[] = $userData['email'] ;//email
    $arr[] = password_hash($userData['password'],PASSWORD_DEFAULT) ;//password⇒ハッシュ化する必要有

    // try-catchで例外処理
    try{
    // ここで、connectのSQL実行準備をする
    $stmt = connect()->prepare($sql);

    $result = $stmt->execute($arr);
    // これがtrueに変わる
    return $result;

    }catch(\Exception $e){
      return $result;
    }

    

  }

  // ログイン処理
  public static function login($email, $password){
    // 結果の初期定義
    $result=false;

    // ユーザをemailから検索して取得⇒別のロジックで作ろう！
    $user = self::getUserByEmail($email);
    // 成功すると、userがreturn, 失敗すると $result=falseとなる

    // var_dump($user);
    // return;

    // emailが存在しない時
    if($user===false){
      $_SESSION['msg']='There is no email in our service';
      return $result;
    }


    // パスワードの照会
    if(password_verify($password, $user['password'])){
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result =true;
      return $result;
    }else{
    $_SESSION['msg']="The password is incorrect";
    return $result;
    }
  }

  // emailからuserを取得するメソッド
  public static function getUserByEmail($email){

    $result =false;
    // sqlの準備
    // sqlの実行
    // sqlの結果を返す

    // SQL文には、入れるvalue値を直接書かない⇒プレスホルダー⇒Securityのため
    $sql ='SELECT * FROM users WHERE email=?';

    // email(引数)を配列に入れる
    $arr =[];
    $arr[] = $email ;//name

    // try-catchで例外処理
    try{
    // ここで、connectのSQL実行準備をする
    $stmt = connect()->prepare($sql);
    $stmt->execute($arr);
    // 実行した後、その値をfetchで返す
    $user = $stmt->fetch();
    // これがtrueに変わる
    return $user;

    }catch(\Exception $e){
      return $result;
    }

  }

  // ログインチェックメソッド
  // param : void
  // return : bool $result
  public static function checkLogin(){

    $result = false;

    // セッションにログインユーザーが入っていなかったらfalse
    if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id']>0){
      return $result = true;
    }


    return $result;

  }

  // ログアウト処理
  public static function logout(){
    $_SESSION =array();
    session_destroy();
  }
}

?>