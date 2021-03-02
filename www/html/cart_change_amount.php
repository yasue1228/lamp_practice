<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを取得
require_once MODEL_PATH . 'item.php';
// カート関数ファイルを取得
require_once MODEL_PATH . 'cart.php';
// ログインチェックをするセッションを開始する
session_start();
// ログイン状態をチェックする
if(is_logined() === false){
  // ログインしていない場合ログインページにリダイレクトする
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
// データベースからログインしたユーザー情報を取得
$user = get_login_user($db);
// postから取得した'cart_id'を$cart_idに代入
$cart_id = get_post('cart_id');
// postから取得した'amount'を$amountに代入
$amount = get_post('amount');
// データベースに登録されている$cart_idの数量を更新する
if(update_cart_amount($db, $cart_id, $amount)){
  // 正常に更新できたメッセージをを表示
  set_message('購入数を更新しました。');
} else {
  // 更新に失敗した場合のエラーメッセージを表示
  set_error('購入数の更新に失敗しました。');
}
// カートページにリダイレクトする
redirect_to(CART_URL);