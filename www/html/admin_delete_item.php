<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 関数ファイルを読み込む
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを読み込む
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを読み込む
require_once MODEL_PATH . 'item.php';
// ログインチェックを行うセッションをスタート
session_start();

// ログイン状況をチェック
if(is_logined() === false){
  // ログインをしていない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}

// データベースに接続する
$db = get_db_connect();
// ログインしたユーザーデータを取得する
$user = get_login_user($db);
// ユーザーが管理者かチェック
if(is_admin($user) === false){
  // 管理者ではない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// POSTで取得したitem_idを$item_idに代入する
$item_id = get_post('item_id');

// アイテム削除関数を利用し、正常に削除できるかチェックする
if(destroy_item($db, $item_id) === true){
  // 商品削除できた場合メッセージを表示
  set_message('商品を削除しました。');
} else {
  // 正常に削除できなかった場合エラーメッセージを表示
  set_error('商品削除に失敗しました。');
}


// 管理者ページにリダイレクトする
redirect_to(ADMIN_URL);