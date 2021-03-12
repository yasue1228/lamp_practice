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
// 受け取ったトークンのチェック
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
// セッションに保存されたトークン情報を削除する
unset($_SESSION['csrf_token']);
// データベース情報を取得する
$db = get_db_connect();
// データベースからログインユーザー情報を取得する
$user = get_login_user($db);
// 注文番号を取得する
$order_id = get_post('order_id');
$purchase_date = get_post('purchase_date');
$total_price = get_post('total_price');
// ログインしているユーザーの注文番号から購入履歴明細を取得して配列変数に代入する
$details = get_purchase_details($db,$order_id);


// カート一覧テンプレートファイルを読み込む
include_once VIEW_PATH . 'purchase_dateils_view.php';