<?php
// 定数ファイルを取得する
require_once '../conf/const.php';
// 関数ファイルを取得する
require_once MODEL_PATH . 'functions.php';
// ログインチェックのセッションを開始
session_start();
// ログイン状況を確認する
if(is_logined() === true){
  // ホームページへリダイレクトする
  redirect_to(HOME_URL);
}
// トークンの取得
$token = get_csrf_token();
// サインアップページテンプレートを読み込む
include_once VIEW_PATH . 'signup_view.php';



