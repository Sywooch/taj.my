<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 22:54
 */

namespace app\models;

use Yii;
use yii\base\Model;

class DialogCreateForm extends Model
{
    public $content;
    public $dialog_id;
    public $title;
    public $user_to;
    public $user_from;
    
    public function rules() {
        return [
            [['message'],  'required', 'message'=> \Yii::t('main', 'Can`t be blank')],
        ];
    }

    public function attributeLabels()
    {
        return [
            [['message'], \Yii::t('main', '') ]
        ];
    }
}