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
// ログインチェックを行うセッションを開始
session_start();
// ログイン状況を確認
if(is_logined() === false){
  // ログインしていない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// データベース情報を取得
$db = get_db_connect();
// ログインしたユーザー情報をデータベースから取得
$user = get_login_user($db);
// POSTから取得した'cart_id'を$cart_idに代入
$cart_id = get_post('cart_id');
// データベースから$cart_idを削除する
if(delete_cart($db, $cart_id)){
  // 正常に削除できた場合のメッセージを表示
  set_message('カートを削除しました。');
} else {
  // 削除できなかった場合エラーメッセージを表示
  set_error('カートの削除に失敗しました。');
}
// カートページにリダイレクトする
redirect_to(CART_URL);