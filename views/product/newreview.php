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

                <?= \app\components\BreadcrumbWidget::widget([
                    'path'          => 'ProductReview',
                    'category'      => $data['product']['category'],
                    'product'       => $data['product'],
                ])?>

                <h1 class="pagename" ><?=$data['product']->getTitle();?></h1>
                <div class="content">
                    <div class="review-container">
                        <div class="product__list__item">
                            <div class="product__list__item__img">
                                <img src="<?=$data['product']->image?>" alt="">
                            </div>
                            <div class="product__info">
                                <h2 class="review-heading"><?=$data['product']->getTitle()?></h2>
                                <div class="product__social">
                                    <?= $data['product']->getShowStars()?>
                                    <div class="like_type2">
                                        <i class="fas fa-heart"></i>
                                        <div class="count__like"><?=$data['product']->count_reviews?></div>
                                    </div>
                                    <div class="comment">
                                        <i class="far fa-comment"></i>
                                        <div class="count__comment"><?=$data['product']->avg_rank?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                $form = ActiveForm::begin([
                                    'action'    => '/upload/review-add',
                                    'options' => [
                                        'class' => 'form-horizontal col-md-12',
                                        'enctype' => 'multipart/form-data',
                                        'id'        => 'add-review-main'
                                    ],
                                ]);?>
                                <div class="hidden">
                                    <?php
                                        echo $form->field($data['model'], 'rank')->hiddenInput(['value'=> 0])->label(false);
                                        echo $form->field($data['model'], 'product_id')->hiddenInput(['value'=> $data['product']['id']])->label(false);
                                        echo $form->field($data['model'], 'recommend_status')->hiddenInput(['value'=> ''])->label(false);
                                        echo $form->field($data['model'], 'content')->hiddenInput(['value'=> 0])->label(false);
                                    ?>
                                </div>
                                <div class="col-md-7">
                                    <?= $form->field($data['model'], 'title_'.Yii::$app->language)->label(Yii::t('main', 'Review Title')) ?>
                                    <?= $form->field($data['model'], 'cost') ?>
                                    <?= $form->field($data['model'], 'use_exp')->dropDownList([
                                        '0' => Yii::t('main', 'Not used'),
                                        '1' => Yii::t('main', 'One day of use'),
                                        '2' => Yii::t('main', 'Few days of use'),
                                        '3' => Yii::t('main', 'One week of use'),
                                        '4' => Yii::t('main', 'Month of use'),
                                        '5' => Yii::t('main', 'More than month'),
                                    ])->label(Yii::t('main', 'Experience of use')); ?>
                                    <?= $form->field($data['model'], 'recommend_status')->dropDownList([
                                        '1' => Yii::t('main', 'I will recommend this product'),
                                        '0' => Yii::t('main', 'I will not recommend this product'),
                                    ])->label(Yii::t('main', 'Do you recommend this product')); ?>
									<div class="form-group field-review-stars">
										<label class="control-label" for="review-stars"><?=Yii::t('main', 'Rate this product')?></label>
										<div id="review-stars">
											<div class="rank hover_select">
												<?php for($i=0;$i<5;$i++) { ?>
													<i class="fas fa-star"></i>
												<?php } ?>
											</div>
										</div>
									</div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <div>
                                        <img src="/images/reviews/no-photo-available.png" attr-src="/images/reviews/no-photo-available.png" alt="" id="review_trumb" class="img-thumbnail">
                                    </div>
                                    <?= $form->field($data['model'], 'img_main')->fileInput(['attr-title'=>Yii::t('main', 'Review Image'),'class'=>["","nolabel"]])->label(false)  ?>
                                </div>

                                <div class="form-group hidden">
                                    <div class="col-lg-offset-1 col-lg-11">
                                        <?= Html::submitButton(Yii::t('main', 'Post Review'), ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                        </div>
                            <div class="product_content"></div>
                        <div class="row">
                            <div class="col-md-10">
                                <?= $form->field($data['model'], 'reviewContent[]')->textarea(['rows' => 7, 'cols' => 5]) ?>
                            </div>
                            <div class="col-md-2 fullbuttons">
                                <div>
                                    <button class="btn btn-primary add_row_text">
                                        <div>
                                            <span class="glyphicon glyphicon-open-file"></span>
                                            <?= \Yii::t('main', 'Add Row')?>
                                        </div>
                                    </button>
                                </div>
                                <div>
                                    <?php ActiveForm::end() ?>
                                        <?php
                                        $form = ActiveForm::begin([
                                            'id' => 'login-form',
                                            'action'    => '/upload/review-upload',
                                            'options' => [
                                                'class' => 'form-horizontal col-md-12',
                                                'enctype' => 'multipart/form-data',
                                                'id'        => 'add-review-content'
                                            ],
                                        ]);
                                        ?>
                                    <?= $form->field($data['model_content'], 'reviewSubImage')
                                        ->fileInput(['attr-title'=>Yii::t('main', 'Add Image'),'multiple' => true,'class'=>'fancy'])
                                        ->label(false) ?>
                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button onclick="if($('review-reviewcontent').val()!=''){$('.add_row_text').click();}$('form#add-review-main').submit()" class="btn btn-success btn-block" id="post_new_review"><?=Yii::t('main', 'Post Review');?></button>
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

        function readURL(input) {
			setTimeout(function() {
				if(!$(input).closest('.form-group').hasClass('has-error')) {
				  if (input.files && input.files[0]) {
					var reader = new FileReader();
				
					reader.onload = function(e) {
					  $('img#review_trumb').attr('src', e.target.result);
					}
				
					reader.readAsDataURL(input.files[0]);
				  }
				} else {
					$('img#review_trumb').attr('src',$('img#review_trumb').attr('attr-src'));
				}
			},1000);
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

        $('#review-reviewcontent').focus(function() { 
            $('.field-review-reviewcontent .help-block').text('');
            $('.field-review-reviewcontent').removeClass('has-error');
        });
        $('.add_row_text').on('click',function(event) {
            event.preventDefault();
            if($('#review-reviewcontent').val()!='') {
                $('.product_content').append('<div class=\"text\">'+$('#review-reviewcontent').val()+'<div class=\"remove\"></div></div>');
                $('#review-reviewcontent').val('');
                removeContentSet();
                setContent()
            } else {
                $('.field-review-reviewcontent .help-block').text('Please, write your text');
                $('.field-review-reviewcontent').addClass('has-error');
            }
        });

        
        $('.rank.hover_select > i').on('mouseenter',function() {
            var n = $(this).index();
            $(this).closest('.rank').addClass('active');
            var bl = $(this).closest('.rank').find('i');
            for(i=0; i <= n;i++) {
                bl.eq(i).addClass('hover');
            }
        });
        $('.rank.hover_select > i').on('mouseleave',function() {
            $(this).closest('.rank').removeClass('active');
            $(this).closest('.rank').find('i').removeClass('hover');
        });
        
        $('.rank.hover_select > i').on('click',function() {
            var n = $(this).index();
            var bl = $(this).closest('.rank').find('i');
            $('.rank.hover_select > i').removeClass('active');
            for(i=0;i <= n;i++) {
                bl.eq(i).addClass('active');
            }
            $('#review-rank').val(1+n);
        });
        
        $('form#add-review-content input[type=\"file\"]').change(function () {
            if($(this).val()!='') {
                var form = $('form#add-review-content')[0];
                var formData = new FormData(form);

                $('body #loader').addClass('active');
                
                $.ajax({
                    url: \"/upload/sub-image-upload\",
                    type: 'POST',
                    // Form data
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if(data.status=='ok') {
                            $('body #loader').removeClass('active');
                            data.file.forEach(function(element) {
                                $('.product_content').append('<div class=\"img\"><img src=\"/'+element+'\"><div class=\"remove\"></div></div>');
                            });
                            removeContentSet();
                            setContent()
                        } else {
                            if(data.error) alert(data.error);
                        }
                    },
                    error: function () {
                        alert('Server Error.Please,try again latter');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        
        
        
        removeContentSet()
    ");

echo $this->render('/site/content/footer', compact('menu')); ?>

<div id="loader"></div>
