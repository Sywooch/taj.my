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
                    <span class="breadcrumbs-list">Home \ <span class="current"><?= \Yii::t('main', 'Add Product')?></span></span>
                </div>
                <h1 class="pagename"><?= \Yii::t('main', 'Add New Product')?></h1>
                <div class="content">
                    <div class="review-container">
						<?php $form2 = ActiveForm::begin([
							'action'    => '/upload/product-add',
							'options' => [
								'class' => 'form-horizontal col-md-12',
								'enctype' => 'multipart/form-data',
								'id'        => 'add-product-modal'
							],
						]);?>
						<div class="row">
							<div class="col-md-7">
								<?= $form2->field($data['product_model'], 'title') ?>

								
								<div class="form-group">
									<label for="search_product" class="col-form-label"><?=Yii::t('main', 'Select category')?></label>
									<input type="text" class="form-control" id="search_product" placeholder="<?=Yii::t('main', 'type category name')?>">
									<div class="search_product_results category"></div>
								</div>
								
								<?php echo $form2->field($data['product_model'], 'category_id')->hiddenInput(['id'=>'category_id'])->label(false)
								?>
								<?= $form2->field($data['product_model'], 'description')->textarea(['rows' => 4, 'cols' => 5]) ?>
							</div><div class="col-md-5">
								<div>
									<img src="/images/reviews/no-photo-available.png" attr-src="/images/reviews/no-photo-available.png" alt="" id="product_trumb" class="img-thumbnail">
								</div>
								<div class="col-md-12">
									<?= $form2->field($data['product_model'], 'image')
										->fileInput(
											['attr-title'=>Yii::t('main', 'Product Image'),
											'class'=>["","nolabel"],
											'id'=>'review-img_main',
											]
										)
										->label(false);
									?>
								</div>
							</div>
							<div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block" id="post_new_product">Post Product</button>
                            </div>
						</div>
						<?php ActiveForm::end() ?>
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

        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
        
            reader.onload = function(e) {
              $('img#product_trumb').attr('src', e.target.result);
            }
        
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        $(\"input#review-img_main\").change(function() {
          readURL(this);
        });
        
        function removeContentSet() {
            $('.product_content>div>.remove').on('click',function() {
                $(this).parent().remove();
                setContent();
            });
        }
        
        function ProductIdSelector() {
            $('.search_product_results>div').on('click',function() {
				var id =$(this).attr('attr-id');
                if(id>0) {
                    $('input#search_product').val($(this).find('span:eq(-1)').text());
                    $('#category_id').val(id);
                }
				$('.search_product_results').text('');
            });
        }
        
        function CategoryIdSelector() {
            $('.search_category_results>div').on('click',function() {
				var id =$(this).attr('attr-id');
                if(id>0) {
                    $('input#search_product').val($(this).find('div:eq(0)').text());
                    $('#product_category_id').val(id);
                }
				$('.search_category_results').text('');
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
                    url: \"/ajax/category-search\",
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
                                $('.search_product_results').append('<div attr-id=\"'+el['id']+'\"><div class=\"category\">'+cat+'</div></div>');
                            });
                        } else {
                            $('.search_product_results').append('<div class=\"no-result\"><button id=\"addProductBtn\" class=\"btn btn-danger\">Category not found.</button></div>');
                            $('#addProductBtn').on('click',function(){ 
								$('#search_product').focus().val('');
                            });
                        }
                        ProductIdSelector();
                    }
                });
        }
        
        function searchCategory() {
                $('.search_category_results').text('');
                $.ajax({
                    url: \"/ajax/category-search\",
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
                                $('.search_product_results').append('<div attr-id=\"'+el['id']+'\"><div><img src=\"'+el['image']+'\">'+el['name']+'</div><div class=\"category\">'+cat+'</div></div>');
                            });
                        } else {
                            $('.search_product_results').append('<div class=\"no-result\"><button id=\"addProductBtn\" class=\"btn btn-success\">Product not found. Add New Product</button></div>');
                            $('#addProductBtn').on('click',function(){ 
                                $('#AddProductModal #product-title').val($('#search_product').val());
                                $('#AddProductModal').modal('show'); 
                            });
                        }
                        CategoryIdSelector();
                    }
                });
        }
        
        $('#search_product').keypress(function() {
            if (typeof timerSearchProduct !== 'undefined') { 
                clearTimeout(timerSearchProduct);
            }
           
           timerSearchProduct = setTimeout(searchProduct, 500);
        });
        
        removeContentSet()
    ");

echo $this->render('/site/content/footer', compact('menu')); ?>

<div id="loader"></div>
