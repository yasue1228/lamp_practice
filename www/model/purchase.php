<?php
// 関数ファイルを取得
require_once MODEL_PATH . 'functions.php';
// データベースファイルを取得
require_once MODEL_PATH . 'db.php';

function insert_purchase_history($db,$user,$total_price){
    $sql = "
    INSERT INTO
    purchase_history(
        user_id,
        total_price
    )
    VALUES(:user_id, :total_price)
    ";
    return execute_query($db,$sql,array(':user_id'=>$user,':total_price'=>$total_price));
}

function insert_purchase_datails($db,$carts,$order_id){
   
    foreach($carts as $cart){
        if(dateils($db,$cart,$order_id) === false){
           return false;
        }
    
    }
    return true;
}
function dateils($db,$cart,$order_id){
    $sql = "
    INSERT INTO
    purchase_details(
        item_id,
        item_price,
        amount,
        order_id
    )
    VALUES(:item_id,:item_price,:amount,:order_id)
        ";
        return execute_query($db, $sql, array('item_id'=>$cart['item_id'],':item_price'=>$cart['price'],':amount'=>$cart['amount'],':order_id'=>$order_id));
}

function get_purchase_history($db,$user_id){
    $sql = "
    SELECT
    order_id,
    purchase_date,
    total_price
    FROM
    purchase_history
    WHERE
    user_id = :user_id
    ORDER BY
    purchase_date DESC
    ";

    return fetch_all_query($db,$sql,array(':user_id'=>$user_id));
   
}

function get_all_purchase_history($db){
    $sql = "
    SELECT
    order_id,
    purchase_date,
    total_price
    FROM
    purchase_history
    ORDER BY
    purchase_date DESC
    ";

    return fetch_all_query($db,$sql);
   
}

function get_purchase_details($db,$order_id){
    $sql = "
    SELECT
    purchase_details.item_id,
    items.name,
    purchase_details.item_price,
    purchase_details.amount
    FROM
    purchase_details
    INNER JOIN
    items
    ON
    purchase_details.item_id = items.item_id
    WHERE
    purchase_details.order_id = :order_id
    ";
    return fetch_all_query($db,$sql,array('order_id'=>$order_id));
}



