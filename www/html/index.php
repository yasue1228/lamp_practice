<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得する
require_once MODEL_PATH . 'functions.php';
// ユーザー関数ファイルを取得
require_once MODEL_PATH . 'user.php';
// アイテム関数ファイルを取得
require_once MODEL_PATH . 'item.php';
// ログインチェックを行うセッションを開始する
session_start();
// ログイン状態を確認する
if(is_logined() === false){
  // ログインしていない場合ログインページへリダイレクトする
  redirect_to(LOGIN_URL);
}
// データベース情報を取得する
$db = get_db_connect();
// データベースからログインしたユーザー情報を取得
$user = get_login_user($db);
// データベースから商品情報を取得する
$items = get_open_items($db);
// トークンの取得
$token = get_csrf_token();
// 商品一覧テンプレートを読み込む
include_once VIEW_PATH . 'index_view.php';