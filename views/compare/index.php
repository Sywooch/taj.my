<?php
use yii\helpers\Url;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
<main>
    <div class="container">
        <div class="center">
            <h1><?=\Yii::t('main', 'PrsCompare');?></h1>
            <?php if(count($data['products'])>0) { ?>
                <table class="table compare">
                    <thead>
                    </thead>
                    <tbody>
                       <tr>
                          <?php foreach($data['products'] as $p) { ?>
                                  <td>
                                      <a href="<?=Url::to(
                                          ['product/product',
                                          'category_link'=>$p['category']->link,
                                          'link'=>$p->link
                                          ], true);?>" title="">
                                              <?=$p->getTitle();?>
                                      </a>
                                  </td>
                          <?php } ?>
							<?php if(count($data['products'])==1) { ?>
								<td>
									<div class="search_block">
										<input class="form-control" name="searchProductCompare" value="" placeholder="Search product">
									</div>
								</td>
							<?php } ?>
                      </tr>
                       <tr class="text-center">
                          <?php foreach($data['products'] as $p) { ?>
                                  <td>
                                      <?=$p->category->getTitle();?></td>
                          <?php } ?>
                      </tr>
                       <tr class="text-center">
                          <?php foreach($data['products'] as $p) { ?>
                                <td>
                                    
                                <div class="product__star product__star--category">
                                        <?php for($i=0;$i<$p->avg_rank;$i++) {?>
                                            <i class="fas fa-star"></i>
                                        <?php } ?>
                                        <?php for($i=5;$i>$p->avg_rank;$i--) {?>
                                            <i class="far fa-star"></i>
                                        <?php } ?>
                                </div>
                                </td>
                          <?php } ?>
                        </tr><tr class="text-center">
                          <?php foreach($data['products'] as $p) { ?>
                            <td>
                                    <i class="far fa-comment-alt"></i> <?=$p->count_reviews?>
                            </td>
                          <?php } ?>
                      </tr>
                       <tr class="text-center">
                          <?php foreach($data['products'] as $p) { ?>
                              <td><img src="<?=$p->image?>" alt="" class="img-thumbnail"></td>    
                          <?php } ?>
                      </tr>
                       <tr>
                          <?php foreach($data['products'] as $p) { ?>
                            <td>
                               <?=$p->description?>
                            </td>    
                          <?php } ?>
                      </tr>
                      
                      
                                  
                          
                  </tbody>
                  </table>
            <?php } else { ?>
				<div class="search_block">
					<input class="form-control" value="" name="searchProductCompare" placeholder="Search product">
				</div>
			<?php } ?>
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

<?=$this->render('/site/content/footer', compact('menu')); ?>