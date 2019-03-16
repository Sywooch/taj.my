<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 1:19
 */
use yii\bootstrap\Html;
?>

<?=Html::a(\Yii::t('main', 'Home'), ['/'], ['class' => 'bread homepage']); ?> \
<?php
foreach($category as $c) {?>
    <?=Html::a($c['name'], $c['type'], ['class' => 'bread category']); ?> \
<?php } ?>
    <?=Html::tag('span',$current, ['class' => 'bread last']); ?>
