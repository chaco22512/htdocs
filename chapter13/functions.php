<?php

// エスケープ対策
// 引数：string $str =>対象の文字列
// return : string 処理された文字列
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// CSRF対策⇒ワンタイムトークン作成
// 引数　void
// return : string csrf_token
// token作成⇒フォームからそのtokenを送信⇒送信後の画面でそのtokenを照会⇒token削除
function setToken(){
  // token生成
  $csrf_token = bin2hex(random_bytes(32));
  // tokenをセッション内に入れる
  $_SESSION['csrf_token']=$csrf_token;
  
  return $csrf_token;
}

?>