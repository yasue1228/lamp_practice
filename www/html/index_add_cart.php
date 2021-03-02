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
// ログインチェックをするセッションをスタート
session_start();
// ログイン状態を確認する
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

// データベース情報を取得する
$db = get_db_connect();
// データベースからログインしたユーザー情報を取得
$user = get_login_user($db);

// ポストで取得したitem_idを$item_idに代入
$item_id = get_post('item_id');
// 取得した$item_idをカートに登録する
if(add_cart($db,$user['user_id'], $item_id)){
  // 正常に登録できた場合メッセージを表示
  set_message('カートに商品を追加しました。');
} else {
  // 登録に失敗した場合エラーメッセージを表示
  set_error('カートの更新に失敗しました。');
}
// 購入者ページにリダイレクトする
redirect_to(HOME_URL);