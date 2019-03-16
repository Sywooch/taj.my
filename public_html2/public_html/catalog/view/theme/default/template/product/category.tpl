<?php echo $header; ?>
<?
if ($column_left && $column_right) {
  $class = "col-xs-12 col-sm-6";
} elseif($column_left || $column_right) {
  $class = 'col-xs-12 col-sm-9';
} else {
  $class = "col-xs-12";
}
?>
<div class="category">
  <div class="container">
    <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
    </div>
  </div>



  <div class="container categor555">
    <div class="row">
      <? if ($column_left) { ?>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".column-left" aria-expanded="false" aria-controls="column-left">
        <span class="sr-only">Фильтр</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <div class="col-xs-12 col-sm-3 column-left collapse">
        <?= $column_left ?>
      </div>
      <? } ?>
      
      <div class="<?= $class ?> content">
        <div id="content">
          <?php echo $content_top; ?>

          <h1><?php echo $heading_title; ?></h1>

		    <? if ($products) { ?>
    <div class="product-filter text-center">
           
            <div class="sort"><b><?php echo $text_sort; ?></b></div>
      <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
          <input type="radio" id="<?= $sorts['id'] ?>" onclick="location = this.value;" value="<?php echo $sorts['href']; ?>" checked="checked">
          <label for="<?= $sorts['id'] ?>"><?php echo $sorts['text']; ?></label>
        <?php } else { ?>
          <input type="radio" id="<?= $sorts['id'] ?>" onclick="location = this.value;" value="<?php echo $sorts['href']; ?>">
          <label for="<?= $sorts['id'] ?>"><?php echo $sorts['text']; ?></label>
        <?php } ?>
      <?php } ?>
	</div>
	<? } ?>
		  
          <!-- <?php if ($categories) { ?>
          <h2><?php echo $text_refine; ?></h2>
          <div class="category-list">
            <?php if (count($categories) <= 5) { ?>
            <ul>
              <?php foreach ($categories as $category) { ?>
              <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
              <?php } ?>
            </ul>
            <?php } else { ?>
            <?php for ($i = 0; $i < count($categories);) { ?>
            <ul>
              <?php $j = $i + ceil(count($categories) / 4); ?>
              <?php for (; $i < $j; $i++) { ?>
              <?php if (isset($categories[$i])) { ?>
              <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?> -->

          <?php if ($products) { ?>
          <!-- <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div> -->

          <div class="product-grid row">
		  
            <!--<div class="row">-->
              <?php foreach ($products as $product) { ?>
              <div class="col-xsm-6 col-sm-4 col-md-3 product">
                <!--<div class="product">-->

                  <?php if ($product['thumb']) { ?>
                  <div class="image"><a href="<?php echo $product['href']; ?>"><img class="img-responsive center-block" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
                  <?php } ?>

                  <div class="featured-description"><?php echo $product['description']; ?></div>

                  <?php if ($product['price']) { ?>

                  <div class="price text-center">
                    <?php if (!$product['special']) { ?>
                      <?php echo $product['price']; ?>
                    <?php } else { ?>
                    <span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span>
                    <?php } ?>

                   
                  </div>
                  <?php } ?>

                  <?php if ($product['rating']) { ?>
                  <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                  <?php } ?>

                  <div class="cart">
                    
                    <button class="btn text-uppercase" onclick="addToCart('<?= $product['product_id'] ?>');"><?= $button_cart ?></button>
                  </div>

                  <!-- <div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
                  <div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div> -->
                <!--</div>-->
              </div>
              <?php } ?>
            <!--</div>-->
          </div>

          <div class="pagination"><?php echo $pagination; ?></div>
          
          <?php } ?>
          <?php if (!$categories && !$products) { ?>
          <div class="content"><?php echo $text_empty; ?></div>
          <div class="buttons">
            <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
          </div>
          <?php } ?>

          <?php if ($thumb || $description) { ?>
          <div class="category-info">
            <?php if ($thumb) { ?>
            <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
            <?php } ?>

            <?php if ($description) { ?>
            <?php echo $description; ?>
            <?php } ?>
          </div>
          <?php } ?>

          <?php echo $content_bottom; ?>
        </div>
      </div>

      <? if ($column_right) { ?>
      <div class="col-xs-12 col-sm-3 column-right">
        <?= $column_right ?>
      </div>
      <? } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>