<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関するファイル読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関するファイル読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うためのセッションを開始
session_start();
// ログインチェック関数
if(is_logined() === false){
  // ログインがされていない場合はログインページにリダイレクトする
  redirect_to(LOGIN_URL);
}
// DBを取得
$db = get_db_connect();
// DBを利用してユーザーデータを取得
$user = get_login_user($db);
// 取得したユーザーデータが管理者かチェック
if(is_admin($user) === false){
  // 管理者ではない場合ログインページにリダイレクトする
  redirect_to(LOGIN_URL);
}
// POSTで取得したitem_idを$item_idに代入
$item_id = get_post('item_id');
// POSTで取得したステータスを$changes_toに代入
$changes_to = get_post('changes_to');
//$changes_toの値が'open'かチェック 
if($changes_to === 'open'){
  // trueの場合データーベースのitemのステータスをOPENに変更する
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  // ステータス変更のメッセージを表示
  set_message('ステータスを変更しました。');
  // $changes_toの値が'open'ではなかった場合は'close'か確認する
}else if($changes_to === 'close'){
  // trueの場合データーベースのitemのステータスをCLOSEに変更する
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
   // ステータス変更のメッセージを表示
  set_message('ステータスを変更しました。');
  // $changes_toの値が'open''close'どちらでもない場合
}else {
  // ステータス変更エラーメッセージを表示
  set_error('不正なリクエストです。');
}

// 管理ページへリダイレクトする
redirect_to(ADMIN_URL);