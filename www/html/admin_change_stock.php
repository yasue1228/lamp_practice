<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うセッションをスタート
session_start();
// ログインチェック関数を利用
if(is_logined() === false){
  // ログインがされていない場合ログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// トークンのチェック
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
// セッションに保存されたトークン情報を削除する
unset($_SESSION['csrf_token']);

// データベースを取得
$db = get_db_connect();
// データベースからユーザー情報を取得
$user = get_login_user($db);

//取得したユーザー情報が管理者かチェック
if(is_admin($user) === false){
  // 管理者ではない場合ログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// POSTで取得したitem_idを$item_idに代入
$item_id = get_post('item_id');
// POSTで取得した在庫数を$stockに代入
$stock = get_post('stock');

// データベースのstock情報を正常に変更できるかチェックする
if(update_item_stock($db, $item_id, $stock)){
  // 正常に変更した場合のメッセージを表示
  set_message('在庫数を変更しました。');
} else {
  // エラーメッセージ
  set_error('在庫数の変更に失敗しました。');
}
// 管理者ページにリダイレクトする
redirect_to(ADMIN_URL);