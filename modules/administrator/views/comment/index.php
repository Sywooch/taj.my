<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Review Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php
//                    echo "<pre>";
//                    var_export($dataProvider->models);
//                    echo "</pre>";
//                    die;
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//			[
//				'label' => 'Review',
//				'options' => ['class' => 'grid-view1'],
//				'attribute' => 'purchaseObjectInfo',
//				'format' => 'raw',
//				'value' => function ($data) {
//
////                echo "<pre>";
//////                var_export($data);
////                    var_export($data->reviews);
////                echo "</pre>";
////                die;
//                    if($data->review==null){
//                        $img = '';
//                    }else{
//                        $img = $data->review->getImage();
//                    }
//					return '<a href="/adminpanel/review/update?id=84'.$data->review->id.'">
//				            <img width="40" src="'.$img.'">'.
//					        StringHelper::truncate($data->review->title_en, 40).
//					        '</a>';
//                   // return '<a href="/adminpanel/review/update?id=84'.$data->review->id.'">link</a>';
//				}
//			],
            //'lang',
			[
				'label' => 'User',
				'format' => 'raw', 
				'value' => function($data) {
					return '<img width="40" src="'.$data->author->getAvatar().'">'.
					$data->author->name. ' <b>(ID: '.$data->author->user_id.')';
				}
			],
			[
				'label' => 'Comment',
				'attribute' => 'purchaseObjectInfo',
				'format' => 'raw', 
				'value' => function ($data) {
					$return = '';
					foreach($data->reviewCommentContent as $rC) {
						$return.= '<div><span class="label label-primary">'.$rC['lang'].':</span><div style="display:inline-block"> '.StringHelper::truncate($rC->content, 60).'</div></div>';
					}
					return $return;
				}
			],
			[
				'label'		=>'Actions',
				'format'	=>'raw',
				'value'		=> function($data) {
					if($data->status!=0){$publish = 'btn-success';$unpublish ='btn-default';}
					elseif($data->status!=1){$unpublish = 'btn-success';$publish ='btn-default';}
						return 
							Html::a('Publish','/adminpanel/comment/update?status=1&update_status=1&id='.$data->id, ['class'=>'btn '.$publish,'target'=>'_blank', 'data-pjax'=>"0", 'onclick'=>'commentChangeStatus($(this));'] ).
							Html::a('Hide','/adminpanel/comment/update?status=0&update_status=1&id='.$data->id, ['class'=>'btn '.$unpublish,'target'=>'_blank', 'data-pjax'=>"0", 'onclick'=>'commentChangeStatus($(this));']);
					
				}
			],
            'create_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
	<script>
	function commentChangeStatus(el) {
		event.preventDefault()
		if(!el.hasClass('btn-success')) {
			jQuery.ajax({
				url: el.attr('href') 
			}).done(function() {
					el.closest('td').find('a.btn-success').addClass('btn-default').removeClass('btn-success');
					el.addClass('btn-success').removeClass('btn-default');
			});
		}
	}
</script>
</div>
