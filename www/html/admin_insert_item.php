<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを取得
require_once MODEL_PATH . 'item.php';
// ログインチェックを行うセッションを取得
session_start();
// ログイン状況をチェックする
if(is_logined() === false){
  // ログインしていない場合ログインページにリダイレクトする
  redirect_to(LOGIN_URL);
}
// データベース情報を取得
$db = get_db_connect();
// ログイン情報を取得
$user = get_login_user($db);
// ログインしたユーザーが管理者かチェックする
if(is_admin($user) === false){
  // 管理者ではない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// ポストで取得した'name'情報を$nameに代入
$name = get_post('name');
// ポストで取得した'price'情報を$priceに代入
$price = get_post('price');
// ポストで取得した'status'情報を$statusに代入
$status = get_post('status');
// ポストで取得した'stock'情報を$stockに代入
$stock = get_post('stock');
// ポストで取得した'image'情報を$imageに代入
$image = get_file('image');
// 取得したアイテム情報をデータベースに登録する
if(regist_item($db, $name, $price, $stock, $status, $image)){
  // 正常に商品が登録できた場合のメッセージを表示
  set_message('商品を登録しました。');
}else {
  // 商品登録ができなかった場合エラーメッセージを表示
  set_error('商品の登録に失敗しました。');
}

// 管理者ページへリダイレクトする
redirect_to(ADMIN_URL);