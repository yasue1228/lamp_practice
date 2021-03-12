<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴明細</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'cart.css')); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴明細</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($details) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>購入金額</th>
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td><?php print(h($order_id));?></td>
            <td><?php print(h($purchase_date)); ?></td>
            <td><?php print(h(number_format($total_price))); ?>円</td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($details as $read){ ?>
          <tr>
            <td><?php print(h($read['name']));?></td>
            <td><?php print(h(number_format($read['item_price']))); ?>円</td>
            <td><?php print(h(number_format($read['amount']))); ?>個</td>
            <td><?php print(h(number_format($read['item_price']*$read['amount']))); ?>円</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>購入詳細はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>