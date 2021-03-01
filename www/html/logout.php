<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// セッションを開始
session_start();
// セッション変数を全て削除
$_SESSION = array();
// sessionに関する設定を取得
$params = session_get_cookie_params();
// sessionに利用しているクッキーの有効期限を過去に設定することで無効化
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
// セッションIDを無効化
session_destroy();
// ログインページへリダイレクトする
redirect_to(LOGIN_URL);

