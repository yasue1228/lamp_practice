<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// ログインチェックのセッションを開始
session_start();
// ログイン状況を確認
if(is_logined() === true){
  // ログインしている場合はホームページへリダイレクトする
  redirect_to(HOME_URL);
}
// 受け取ったトークンのチェック
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
// セッションに保存されたトークン情報を削除する
unset($_SESSION['csrf_token']);

// ポストで取得した'name'を$nameに代入
$name = get_post('name');
// ポストで取得した'password'を$passwordに代入
$password = get_post('password');
// ポストで取得した'password_confirmation'を$password_confirmationに代入
$password_confirmation = get_post('password_confirmation');
// データベース情報を取得
$db = get_db_connect();

try{
  //取得したユーザー情報を データベースに登録する関数を$resultに代入
  $result = regist_user($db, $name, $password, $password_confirmation);
  // ユーザー情報をデータベースに正常に登録できたか確認
  if( $result=== false){
    // 登録に失敗した場合エラーメッセージを表示する
    set_error('ユーザー登録に失敗しました。');
    // サインアップページへリダイレクトする
    redirect_to(SIGNUP_URL);
  }
  // データベース処理に異常が発生した場合
}catch(PDOException $e){
  // エラーメッセージを表示
  set_error('ユーザー登録に失敗しました。');
  // サインアップページへリダイレクトする
  redirect_to(SIGNUP_URL);
}
// 正常に登録できた場合メッセージを表示
set_message('ユーザー登録が完了しました。');
// データベースにユーザー情報をログインする
login_as($db, $name, $password);
// ホームページにリダイレクトする
redirect_to(HOME_URL);