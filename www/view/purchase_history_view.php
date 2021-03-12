<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'cart.css')); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($histories) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($histories as $history){ ?>
          <tr>
            <td><?php print(h($history['order_id']));?></td>
            <td><?php print(h($history['purchase_date'])); ?></td>
            <td><?php print(h(number_format($history['total_price']))); ?>円</td>
            <td>
              <form method="post" action="purchase_dateils.php">
                <input type="submit" value="購入明細表示" class="btn btn-danger delete">
                <input type="hidden" name="order_id" value="<?php print(h($history['order_id'])); ?>">
                <input type="hidden" name="purchase_date" value="<?php print(h($history['purchase_date'])); ?>">
                <input type="hidden" name="total_price" value="<?php print(h($history['total_price'])); ?>">
                <input type="hidden" value="<?php print(h($token)); ?>" name="token">
              </form>

            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>