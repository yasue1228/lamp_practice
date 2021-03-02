<?php
// 定数ファイルを取得
require_once '../conf/const.php';
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// ログインチェックのセッションを開始
session_start();
// ログイン状態を確認する
if(is_logined() === true){
  // ログインしていた場合ホームページにリダイレクトする
  redirect_to(HOME_URL);
}
// トークンの取得
$token = get_csrf_token();
// ログインページのテンプレートを読み込む
include_once VIEW_PATH . 'login_view.php';