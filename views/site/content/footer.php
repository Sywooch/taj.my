<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 19.11.2018
 * Time: 18:19
 */

//use Yii;
use app\models\DialogForm;
use app\models\DialogCreateForm;
use yii\widgets\ActiveForm;

use yii\helpers\Url; ?>
<footer>
    <div class="redline">
        <div class="container">
            <ul class="footer__menu">
                <?php foreach($menu['footer'] as $m) {?>
                    <li><a href="<?=Url::to([$m->link], true);?>"><?=$m->name?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="footer__links">
            <span>“Copying is allowed only with the written permission of the site administration. <a href="/information/politikakonfidentsialnosti" title="User Agreement">User Agreement</a>. <a href="/information/pp" title="Affiliate program">Affiliate program</a>. 
			For questions about the site, write to <a href="mailto:info@tajrobtak.com">info@tajrobtak.com</a>. <a href="/information/advert" title="Advertising on the website">Advertising on the website</a>.</span>
        </div>
    </div>
</footer>
<div class="modal fade" id="loginFirstModal" tabindex="-1" role="dialog" aria-labelledby="loginFirstModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Please, login first</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Sorry, this function only for register users. Please, register first. It takes only 2 minutes!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Not now</button>
                <a href="/user/register" class="btn btn-primary">Register</a>
                <a href="/user/login" class="btn btn-success">Login</a>
            </div>
        </div>
    </div>
</div>
<?php  if(Yii::$app->user->isGuest) { ?>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Please, login first</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Sorry, this function only for register users. Please, register first. It takes only 2 minutes!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Not now</button>
                <a href="/user/register" class="btn btn-primary" data-dismiss="modal">Register</a>
                <a href="/user/login" class="btn btn-success" data-dismiss="modal">Login</a>
            </div>
        </div>
    </div>
</div>

<?php } else { ?>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Report Problem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<?php $form = ActiveForm::begin(['action' => ['upload/message?report=1']]); ?>
				<div class="modal-body">
					<p>
						If you believe that this publication violates the rules of the site, describe the problem in detail and send it to us. The time for consideration of the application is 24 hours.
					</p>
					<textarea class="form-control" rows="5" id="comment" name="Support[message]" placeholder="Describe problem"></textarea>
					<div class="new__comment__alert alert alert-success" role="alert" style="display:none" id="commentResult">
					  <strong>Success!</strong> Thank you for your report!
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<div class="btn btn-danger pageReport">Report</div>
				</div>
				
				<input type="hidden" name="Support[name]" value="<?=Yii::$app->user->identity->username?> ">
				<input type="hidden" name="Support[email]" value="<?=Yii::$app->user->identity->email?>">
				<input type="hidden" name="Support[title]" value="Report to: <?=Url::to();?>">
				
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="modal fade" id="writeNewMsg" tabindex="-1" role="dialog" aria-labelledby="writeNewMsg" aria-hidden="true">
	<?php $dialog = new DialogForm;?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Write New Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<?php $form = ActiveForm::begin([
                        'id' => 'dialog_footer-form',
                        'action'    => '/ajax/dialog',
                    ]) ?>
					
						<?=$form->field($dialog, 'title')
							->textInput(['id'=>'dialog_footer-title'])
							->label('Title');?>
                        <?= $form->field($dialog, 'content')
							->textarea(['rows' => '3', 'id'=>'dialog_footer-content'])
							->label('Message') ?>
                        <?= $form->field($dialog, 'user_to')
							->HiddenInput(['id'=>'dialog_footer-user_to'])
							->label(false) ?>
                        <?= $form->field($dialog, 'dialog_id')
							->HiddenInput(['value'=>0, 'id'=>'dialog_footer-dialog_id'])
							->label(false); ?>
                           
                    
				<?php ActiveForm::end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <span id="writeNewMsgSend" class="btn btn-primary">Send</span>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<style>
    .product__list__item__img img {
        max-width: 100%;
        height: auto;
        max-height: 100%;
        margin: 0 auto;
        display: block;
        padding: 3%;
    }
    .main-menu, .footer__menu {
        margin-bottom:0;
    }
    .select-lang>*:nth-child(1){margin-right:10px;}

</style>