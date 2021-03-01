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
// ログインチェックを行うセッションスタート
session_start();
// ログイン状況を確認
if(is_logined() === false){
  // ログインしていない場合はログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// データベースの情報を取得
$db = get_db_connect();
// データベースからログインしたユーザー情報を取得
$user = get_login_user($db);
// データベースからユーザーのカート情報を取得
$carts = get_user_carts($db, $user['user_id']);
// 商品を正常に購入できるかチェック
if(purchase_carts($db, $carts) === false){
  // 購入できなかった場合エラーメッセージを表示
  set_error('商品が購入できませんでした。');
  // カートページへリダイレクトする
  redirect_to(CART_URL);
} 
// 購入金額を$total_priceに代入する
$total_price = sum_carts($carts);
// 購入完了ページテンプレートを読み込む
include_once '../view/finish_view.php';