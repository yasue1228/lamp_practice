<?php
// 定数ファイルを取得する
require_once '../conf/const.php';
// 関数ファイルを取得する
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得する
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを取得する
require_once MODEL_PATH . 'item.php';
// カート関数ファイルを取得する
require_once MODEL_PATH . 'purchase.php';
// ログインチェックを行うセッションを開始する
session_start();
// ログイン状況を確認する
if(is_logined() === false){
  // ログインしていない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}

// データベース情報を取得する
$db = get_db_connect();
// データベースからログインユーザー情報を取得する
$user = get_login_user($db);
// ログインしているユーザーの購入履歴を取得して配列変数に代入する
$histories = get_purchase_history($db,$user['user_id']);
// ログインしているユーザーが管理者だったら全ての購入履歴を取得して配列変数に代入する
if(is_admin($user) === true){
$histories = get_all_purchase_history($db);
}
// トークンを生成して取得
$token = get_csrf_token();
// カート一覧テンプレートファイルを読み込む
include_once VIEW_PATH . 'purchase_history_view.php';