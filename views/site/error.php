<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use app\models\Menu;

$this->title = $name;

$menu['header'] = Menu::find(['name','link'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'position'=>'header' ])->all();
$menu['footer'] = Menu::find(['name','link'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'position'=>'footer' ])->all();
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
<div class="container">
        <div class="site-error">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>

            <p>
                The above error occurred while the Web server was processing your request.
            </p>
            <p>
                Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
</div>
<?=$this->render('/site/content/footer', compact('menu')); ?>
