<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 1:19
 */
use yii\helpers\Url;

$max_page = ceil($count/$limit);
if($count>$limit) {
    if ($page == 0 && $max_page > 0) { ?>
        <div class="product__list__more">
            <a href="<?= Url::to([$path . '/1']); ?>">
                <button>
                    <?= \Yii::t('main', $readMore); ?>
                </button>
            </a>
        </div>
        <p><?= \Yii::t('main', 'Page {0} of {1}.', [$page + 1, $max_page]); ?></p>
    <?php } elseif ($max_page >= $page) { ?>
        <div class="product__list__more pagination">

            <?php //******************PREV******************?>
            <?php if ($page == 1) { ?>
                <a href="<?= Url::to([$firstPath]); ?>">
                    <button>
                        <?= \Yii::t('main', 'Prev'); ?>
                    </button>
                </a>
            <?php } elseif ($page > 1) { ?>
                <a href="<?= Url::to([$path . '/' . ($page - 1)]); ?>">
                    <button>
                        <?= \Yii::t('main', 'Prev'); ?>
                    </button>
                </a>
            <?php } ?>

            <?php //******************NEXT******************?>
            <?php if ($limit * (1 + $page) < $count) { ?>
                <a href="<?= Url::to([$path . '/' . ($page + 1)]); ?>">
                    <button>
                        <?= \Yii::t('main', 'Next'); ?>
                    </button>
                </a>
            <?php } ?>
            <p><?= \Yii::t('main', 'Page {0} of {1}.', [$page + 1, $max_page]); ?></p>
        </div>
    <?php }
}?>