<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>
  <div class="buttons">
    <div class="right"><a href="/" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  
	<?php if (count($order_data['cart'])>0) { ?>
	  <script>
	  dataLayer.push({
		'event': 'checkout',
		'ecommerce': {
		  'checkout': {
			'actionField': {'option': 'Visa'},
			'products': [
			<?php
				$n=0;
				foreach($order_data['cart'] as $product) {
					if($n>0) echo ',';
					if($product['quantity']<1) 
						$product['quantity']=0;
					?>
					{
					  'name': '<?php echo $product['BKEY'], ' ',$product['AKEY']; ?>',
					  'price': '<?php echo $product['price']; ?>',
					  'brand': '<?php echo $product['brand']; ?>',
					  'category': '<?php echo $product['name']; ?>',
					  'quantity': <?php echo $product['quantity']; ?>
				   }<?php 
				   $n++;
				} ?> ]
		 }
	   }
	  });
	  </script>
	<?php } ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>