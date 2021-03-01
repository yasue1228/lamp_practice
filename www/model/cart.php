<?php 
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// データベースファイルを取得
require_once MODEL_PATH . 'db.php';
// ユーザーのカート情報取得の関数
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = :user_id
  ";
  return fetch_all_query($db, $sql,array(':user_id'=>$user_id));
}
// ユーザーがカートに入れたアイテム情報を取得する関数
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = :user_id
    AND
      items.item_id = :item_id
  ";

  return fetch_query($db, $sql,array(':user_id'=>$user_id,':item_id'=>$item_id));

}
// カートに追加処理を行う関数
function add_cart($db, $user_id, $item_id ) {
  // 取得したカート情報を$cartに代入
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    // カート情報が正しくない場合カート書き込み関数に返す
    return insert_cart($db, $user_id, $item_id);
  }
  // 正常に購入処理が行われた場合はcartテーブル更新関数に返す
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}
// カート書き込み関数
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(:item_id, :user_id, :amount)
  ";
// カート情報をデータベースに登録を実行する
  return execute_query($db, $sql,array(':item_id'=>$item_id,':user_id'=>$user_id,':amount'=>$amount));
}
// カート情報更新関数
function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = :amount
    WHERE
      cart_id = :cart_id
    LIMIT 1
  ";
  // カート情報を更新を実行する
  return execute_query($db, $sql,array(':amount'=>$amount,':cart_id'=>$cart_id));
}
// カート情報を削除する関数
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = :cart_id
    LIMIT 1
  ";
// カート情報削除の実行をする
  return execute_query($db, $sql,array(':cart_id'=>$cart_id));
}
// 購入処理関数
function purchase_carts($db, $carts){
  // カートの中身が入っているか確認する
  if(validate_cart_purchase($carts) === false){
    // カートの中身がからの場合falseを返す
    return false;
  }
  foreach($carts as $cart){
    // アイテムの在庫を更新する関数を使用
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
        // 正常に購入できなかった商品名をエラー表示
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
  }
  // カート情報からユーザーIDを削除
  delete_user_carts($db, $carts[0]['user_id']);
}
// カート情報からユーザー情報を削除する関数
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = :user_id
  ";
// ユーザー情報削除を実行する
  execute_query($db, $sql,array(':user_id'=>$user_id));
}

// 購入金額を計算する関数
function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}
// カートに商品が正常に購入できるか確認する関数
function validate_cart_purchase($carts){
  // カートに商品が入っていない場合エラーメッセージを表示
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach($carts as $cart){
    // 購入予定の商品ステータスの確認
    if(is_open($cart) === false){
      // ステータスが非表示の場合エラーメッセージを表示
      set_error($cart['name'] . 'は現在購入できません。');
    }
    // 購入予定の商品数と在庫数の確認
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}

