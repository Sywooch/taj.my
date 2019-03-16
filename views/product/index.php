<?php
use yii\helpers\Url;
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
            <?= \app\components\BreadcrumbWidget::widget([
                'path'          => 'category',
                'category'      => $data['category_info'],
                'current'  => $data['category_info']->getName()
            ])?>
            </div>

            <div class="category-wrap">
                <ul class="category-list">
                    <?php foreach($data['children'] as $child) { ?>
                        <li><a href="<?=Url::to(['products/'.$child->link]); ?>"><?=$child->getName(); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
			<?php if(count($data['products'])>0) {?>
				<h1 class="pagename"><?=\Yii::t('main', 'RevsFeed');?></h1>
				<div class="content">
					<div class="product__list">
						<?php foreach($data['products'] as $p){ ?>
							<div class="product__list__item">
								<div class="product__list__item__img">
									<img src="<?=$p->image;?>" alt="">
								</div>
								<div class="product__info">
									<h2><?=$p->getTitle(); ?></h2>
									<?=$p->getShowStars();?>
									<span class="product__star__desc">
										<?=$p->getShowAvgRank()?><?=$p->getReviewCountText()?>
									</span>
									<div class="product__cat__btn">
                                        <a href="<?=Url::to(['product/addreview','category_link'=>$p['category']->link,'link'=>$p->link,'new'=>'addreview'], true);?>" title="">
											<button class="product__cat__add-review"><?=\Yii::t('main', 'RevWrite');?></button>
										</a>
										<?php if($p->count_reviews||count($p->reviews)>0) { ?>
											<a href="<?=Url::to(['product/product','category_link'=>$p['category']->link,'link'=>$p->link], true);?>" title="">
												<button class="product__cat__read-review"><?=\Yii::t('main', 'RevRead');?> (<span><?=count($p->reviews)?></span>)</button>
											</a>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
                    <?= \app\components\PaginationWidget::widget([
                        'path'      => $data['pagination']['path'],
                        'page'      => $data['pagination']['page'],
                        'limit'     => $data['pagination']['limit'],
                        'count'     => $data['pagination']['count'],
                    ])?>
                <div class="promotion__item promotion__item--horizontal"></div>
            </div>
		<?php } else { ?>
			<h2><?=\Yii::t('main', 'RevsNoFeed');?></h2>
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