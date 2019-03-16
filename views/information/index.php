<?php
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
<main>
    <div class="container">
        <div class="center">
            <h1><?=$data['content']->content->title;?></h1>
            <?=$data['content']->content->content;?>
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