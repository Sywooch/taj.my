<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
//$langForScript = Yii::$app->language;
//$script = <<< JS
//    if("$langForScript"=="ar"){
//        document.querySelector("h1.pagename").style.textAlign = "right";
//    }
//JS;
////маркер конца строки, об€зательно сразу, без пробелов и табул€ции
//$this->registerJs($script);
?>

<?php $this->beginPage() ?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-7101449661048825",
            enable_page_level_ads: true
        });
    </script>

<!--    устаревша€ верси€ адсенс-->
<!--    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
<!--    <script>-->
<!--      (adsbygoogle = window.adsbygoogle || []).push({-->
<!--        google_ad_client: "ca-pub-7101449661048825",-->
<!--        enable_page_level_ads: true-->
<!--      });-->
<!--    </script>-->
<!--	<script>-->
<!--	  (adsbygoogle = window.adsbygoogle || []).push({-->
<!--		google_ad_client: "ca-pub-1910996311142149",-->
<!--		enable_page_level_ads: true-->
<!--	  });-->
<!--	</script>-->


<!--    √угл тэг-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136313284-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-136313284-1');
    </script>

    <!--    метрика-->
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(52815142, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/52815142" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<?php $this->beginBody() ?>
<?php $menu=$this->params['menu'];
//var_export($this->params);die;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
<main>
    <div class="container">
        <div class="center">
            <?= $content ?>
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
<?//=$this->render('/site/content/footer', compact('menu')); ?>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
