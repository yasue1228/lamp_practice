<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// ログインチェックを行うセッションを開始する
session_start();
// ログイン状態を確認する
if(is_logined() === true){
  // ログインしている場合はホームページにリダイレクトする
  redirect_to(HOME_URL);
}
// ポストで取得した'name'を$nameに代入
$name = get_post('name');
// ポストで取得した'password'を$passwordに代入する
$password = get_post('password');
// データベース情報を取得
$db = get_db_connect();

// ログインしたユーザー情報を$userに代入
$user = login_as($db, $name, $password);
// ログインできるか確認
if( $user === false){
// ログインに失敗した場合エラーメッセージを表示
  set_error('ログインに失敗しました。');
  // ログインページにリダイレクトする
  redirect_to(LOGIN_URL);
}
// 正常にログインした場合メッセージを表示
set_message('ログインしました。');
// ログインしたユーザーが管理者か確認する
if ($user['type'] === USER_TYPE_ADMIN){
  // 管理者の場合管理者ページへリダイレクトする
  redirect_to(ADMIN_URL);
}
// ホームページへリダイレクトする
redirect_to(HOME_URL);