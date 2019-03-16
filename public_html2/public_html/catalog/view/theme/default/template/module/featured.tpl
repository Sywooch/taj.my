<div class="box">
  <div class="box-heading">Популярные</div>
  <div class="box-notice">Товары, которые недавно у нас покупали:</div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
		<?php if ($product['thumb']) { ?>
        <div class="image">
		 <div class="stock-label"><?php if($product['qty'] > 0) { ?>есть в наличии<?php } else { ?>нет в наличии<?php } ?></div>
		<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <?php if($product['manufacturer']) { ?>
	  <div class="manufacturer-pr"><span>Производитель: </span><?php echo $product['manufacturer']; ?></div>
	  <?php } ?>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
		<div class="button-block">
		<a href="<?php echo $product['href']; ?>">Подробно</a>
        <div class="cart"><input type="button" value="" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
		</div>
	  </div>
      <?php } ?>
    </div>
  </div>
</div>
