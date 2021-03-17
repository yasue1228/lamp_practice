<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'index.css')); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="get" action="index.php">
        <select name ="sort">
          <option value="new_arrival_order" <?php if($sort==='new_arrival_order'){ print 'selected';} ?>>新着順</option>
          <option value="cheapest_first" <?php if($sort==='cheapest_first'){ print 'selected';} ?>>価格の安い順</option>
          <option value="higest_first" <?php if($sort==='higest_first'){ print 'selected';} ?>>価格の高い順</option>
        </select>
        <input type="submit" name="sort_select" class="btn btn-primary sort" value="並び替える">
      </form>
    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(h(IMAGE_PATH . $item['image'])); ?>">
              <figcaption>
                <?php print(h(number_format($item['price']))); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
                    <input type="hidden" value="<?php print(h($token)); ?>" name="token">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>