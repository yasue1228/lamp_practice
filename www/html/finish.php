<?php
// 定数ファイルを読み込む
require_once '../conf/const.php';
// 関数ファイルを読み込む
require_once MODEL_PATH . 'functions.php';
// ユーザ関数ファイルを読み込む
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを読み込む
require_once MODEL_PATH . 'item.php';
// カート関数ファイルを読み込む
require_once MODEL_PATH . 'cart.php';
// 購入歴関数ファイルを読み込む
require_once MODEL_PATH . 'purchase.php';

// ログインチェックを行うセッションスタート
session_start();
// ログイン状況を確認
if(is_logined() === false){
  // ログインしていない場合はログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// 受け取ったトークンのチェック
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
// セッションに保存されたトークン情報を削除する
unset($_SESSION['csrf_token']);

// データベースの情報を取得
$db = get_db_connect();
// データベースからログインしたユーザー情報を取得
$user = get_login_user($db);
// データベースからユーザーのカート情報を取得
$carts = get_user_carts($db, $user['user_id']);
// トランザクションを開始する
$db -> beginTransaction();
// 商品を正常に購入できるかチェック
if(purchase_carts($db, $carts) === false){
  // ロールバックする
$db -> rollBack();
  // 購入できなかった場合エラーメッセージを表示
  set_error('商品が購入できませんでした。');
  // カートページへリダイレクトする
  redirect_to(CART_URL);
} 
// 購入金額を$total_priceに代入する
$total_price = sum_carts($carts);
// 購入履歴を保存する（ユーザーIDと合計金額）
if(insert_purchase_history($db,$user['user_id'],$total_price)===false){
  // ロールバックする
  $db -> rollBack();
  // エラーメッセージ
  set_error('商品が購入できませんでした');
  // カートページにリダイレクトする
  redirect_to(CART_URL);
}
// オーダーIDを取得
$order_id = $db->lastInsertId('order_id');
// 購入明細を保存する($cartsと注文番号)
if(insert_purchase_datails($db,$carts,$order_id)===false){
  // ロールバックする
  $db -> rollBack();
  // エラーメッセージの表示
  set_error('購入履歴が登録できませんでした');
  // カートページにリダイレクトする
  redirect_to(CART_URL);
}
// コミットする
$db -> commit();
// 購入完了ページテンプレートを読み込む
include_once '../view/finish_view.php';