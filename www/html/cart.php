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
require_once MODEL_PATH . 'cart.php';
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
// データーベースからログインユーザーのカート情報を取得する
$carts = get_user_carts($db, $user['user_id']);
// 購入金額の合計を合計額計算関数から取得する
$total_price = sum_carts($carts);
// トークンを生成して取得
$token = get_csrf_token();
// カート一覧テンプレートファイルを読み込む
include_once VIEW_PATH . 'cart_view.php';