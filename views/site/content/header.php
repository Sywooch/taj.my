<?php
use yii\helpers\Url;

?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<header>
    <div class="container">
        <div class="top">
            <div class="top__logo">
                <a href="<?=Yii::$app->homeUrl?>">
                    <picture>
                        <source media="(min-width: 481px)" srcset="/image/top_logo.png">
                        <source media="(max-width: 480px)" srcset="/image/top_logo_mob.jpg">
                        <img src="dev/image/top_logo.png" alt="Tajrobti">
                    </picture>
                </a>
            </div>
            <div class="top__search">
                <input type="text" id="search" placeholder="<?=\Yii::t('main', 'Search');?>" autocomplete="off">
                <button class="btn btn--simple" id="search__btn"><?=\Yii::t('main', 'Search');?></button>
            </div>
            <div class="top__buttons">
                <a class="top-buttons" href="<?=Url::to(["/product/addreview"], true);?>"><button class="btn btn--green"><?=\Yii::t('main', 'AddReview');?></button></a>
                <a class="top-buttons" href="<?=Url::to(["/compare"], true);?>" alt="">
					<button class="btn btn--grey"><?=\Yii::t('main', 'PrsCompare');?>
						<span id="compare_count"></span>
					</button>
				</a>
                <?= klisl\languages\widgets\ListWidget::widget() ?>
                <?php if (Yii::$app->user->isGuest) { ?>
                    <a class="top-buttons" href="<?=Url::to(['/user/login'], true);?>">
                        <button class="btn btn--simple btn-login" id="login"><?=Yii::t('main', 'Login');?></button>
                    </a>
                <?php } else { ?>
                <a href="<?=Url::to(['/user/settings/profile'], true);?>">
                    <button class="btn btn--simple" id="cabinet">
                        <?= \yii\helpers\StringHelper::truncate(Yii::$app->user->identity->username ,50, '');?>
                    </button>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
<nav>
    <div class="container">
        <ul class="main-menu">
            <?php
            if (isset($menu['title'])){
               echo "<label>".\Yii::t('main', 'Menu')."</label>";
            }
            if(isset($menu['header'])){
            foreach($menu['header'] as $m) { ?>
              <li><a href="<?=Url::to([$m->link], true);?>"><?=$m->name?></a></li>
            <?php }} ?>
        </ul>
    </div>
</nav>
