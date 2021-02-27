<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを取得
require_once MODEL_PATH . 'item.php';
// ログインチェックをするセッションをスタート
session_start();
// ログイン状況を確認する
if(is_logined() === false){
  // ログインしていない場合ログインページを取得
  redirect_to(LOGIN_URL);
}
// データベース情報を取得
$db = get_db_connect();
// ユーザー情報を取得
$user = get_login_user($db);
// ログインしたユーザーが管理者かチェックする
if(is_admin($user) === false){
  // 管理者ではない場合ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベースのアイテム情報を$itemに代入する
$items = get_all_items($db);
// 管理者ページファイルを読み込む
include_once VIEW_PATH . '/admin_view.php';
