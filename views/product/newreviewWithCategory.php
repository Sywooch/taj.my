<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
    <main>
        <div class="container">
            <div class="center">
                <div class="info">
                    <?php foreach($data['blocks'] as $b) { ?>
                        <div class="info__item">
                            <img src="<?=$b->image?>" alt="<?=$b->title?>">
                            <h4><?=$b->title?></h4>
                            <span><?=$b->content?></span>
                        </div>
                    <?php } ?>
                </div>

                <div class="breadcrumbs">
                    <span class="breadcrumbs-list">Home \ <span class="current"><?= \Yii::t('main', 'Add Review')?></span></span>
                </div>
                <h1 class="pagename"><?= \Yii::t('main', 'Add Review')?></h1>
                <div class="content">
                    <div class="review-container">
                        <div class="row">
                            <div class="col-md-6">
								<div class="form-group block-relative">
									<label for="search_product" class="col-form-label"><?=Yii::t('main', 'Select product')?></label>
									<input type="text" class="form-control" id="search_product" placeholder="<?=Yii::t('main', 'enter product name')?>">
									<div class="search_product_results"></div>
								</div>
								<div class="product_content"></div>
							</div>
                            <div class="col-md-6">
								<a href="<?=Url::to(['/addProduct']);?>" id="addNewCategory">
									<div class="btn btn-success">
										<?=Yii::t('main', 'Or add new product')?>
									</div>
								</a>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar">
                <div class="promotion__item promotion__item--square"></div>
                <div class="promotion__item promotion__item--square"></div>
                <div class="promotion__item promotion__item--square"></div>
                <div class="promotion__item promotion__item--square"></div>
                <div class="promotion__item promotion__item--square"></div>
            </div>
        </div>
    </main>
<?php
    $this->registerJs("
        function ProductIdSelector() {
            $('.search_product_results>div').on('click',function() {
				var id =$(this).attr('attr-id');
                if(id>0) {
                    $('input#search_product').val($(this).find('div:eq(0)').text());
                    $('#product_id').val(id);
                }
				$('.search_product_results').text('');
            });
        }
        
        function setContent() {
            var content = new Array();
            var n = 0;
            $('.product_content>div').each(function() {
                n = $(this).index();
                if($(this).hasClass('img')) {
                    val = $(this).find('img').attr('src');
                    content[n] = {'type':'img', 'value': val}; 
                } else {
                    val = $(this).text();
                    content[n] = {'type':'text', 'value': val}; 
                }
            });
            if(content.length>0) {
                $('input#review-content').val(JSON.stringify(content))
            } else {
                $('input#review-content').val('');
            }
        }
        
        function searchProduct() {
                $('.search_product_results').text('');
                $.ajax({
                    url: \"/ajax/product-search\",
                    type: 'POST',
                    // Form data
                    data: {
                        'search' : $('input#search_product').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if(data['products'].length>0) {
                            data['products'].forEach(function(el) {
                                cat = '';
                                el['category'].forEach(function(c) {
                                    cat+= '<span>'+c['name']+'</span>';
                                    console.log(c['name']);
                                });
                                $('.search_product_results').append('<a href=\"'+el.url+'/addreview\"><div attr-id=\"'+el['id']+'\"><div><img src=\"'+el['image']+'\">'+el['name']+'</div><div class=\"category\">'+cat+'</div></div></a>');
                            });
                        } else {
                            $('.search_product_results').append('<div class=\"no-result\"><a href=\"".Url::to(['/addProduct'])."\"><button id=\"addProductBtn\" class=\"btn btn-block btn-success\">Product not found. Add New Product</button></a></div>');
                        }
                    }
                });
        }
        
        $('#search_product').keypress(function() {
            if (typeof timerSearchProduct !== 'undefined') { 
                clearTimeout(timerSearchProduct);
            }
           
           timerSearchProduct = setTimeout(searchProduct, 500);
        });
    ");

echo $this->render('/site/content/footer', compact('menu')); ?>

<div id="loader"></div>
