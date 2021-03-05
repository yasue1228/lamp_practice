-- 購入履歴テーブル　purchase_history
-- 注文番号　order_id (primarykey)
-- 購入日時 purchase_date
-- 該当の注文の合計金額　total_price
-- ユーザーID　user_id

CREATE TABLE purchase_history(
    order_id INT(11) AUTO_INCREMENT,
    purchase_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_price INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    primary key(order_id)
);


-- 購入明細テーブル　purchase_details
-- 購入明細番号　purchase_details_id (primarykey)
-- 商品番号　item_id
-- 購入時の商品価格　item_price
-- 購入数　amount
-- 注文番号　order_id

CREATE TABLE purchase_details(
    purchase_details_id INT(11) AUTO_INCREMENT,
    item_id INT(11) NOT NULL,
    item_price INT(11) NOT NULL,
    amount INT(11) NOT NULL,
    order_id INT(11) NOT NULL,
    primary key(purchase_details_id)
);
